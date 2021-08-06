<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{

    protected SerializerInterface $serializer;
    private ValidatorInterface $validator;

    /**
     * ApiController constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface  $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param      $data
     * @param null $asserts
     *
     * @return Response
     */
    protected function validate($data, $asserts = null): ?Response
    {
        $errors = $this->validator->validate($data, $asserts);

        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            return $this->createBadRequestResponse($errorsString);
        }
        return null;
    }

    /**
     * @param Request $request
     * @param string  $class
     *
     * @return mixed|Response
     */
    protected function readModel(Request $request, string $class)
    {
        // Read out all input parameter values into variables
        $content = $request->getContent();

        // Use the default value if no value was provided
        // Deserialize the input values that needs it
        $model = $this->deserialize($content, $class);

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\Type($class);
        $asserts[] = new Assert\NotNull();
        $response = $this->validate($model, $asserts);

        if ($response instanceof Response) {
            return $response;
        }

        return $model;
    }

    /**
     * Deserializes data from a given type format.
     *
     * @param string $data The data to deserialize.
     * @param string $class The target data class.
     *
     * @return mixed A deserialized data.
     */
    protected function deserialize($data, $class)
    {
        $format = 'application/json';
        return $this->serializer->deserialize($data, $class, 'json');
    }

    /**
     * Serializes data to a given type format.
     *
     * @param mixed $data The data to serialize.
     *
     * @return string A serialized data string.
     */
    protected function serialize($data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * This will return an error response. Usage example:
     *     return $this->createErrorResponse(new UnauthorizedHttpException());
     *
     * @param HttpException $exception An HTTP exception
     *
     * @return Response
     */
    public function createErrorResponse(HttpException $exception): Response
    {
        $statusCode = $exception->getStatusCode();
        $headers = array_merge($exception->getHeaders(), ['Content-Type' => 'application/json']);

        $json = $this->exceptionToArray($exception);
        $json['statusCode'] = $statusCode;

        return new Response(json_encode($json, 15, 512), $statusCode, $headers);
    }

    /**
     * Converts an exception to a serializable array.
     *
     * @param \Exception|null $exception
     *
     * @return array
     */
    private function exceptionToArray(\Exception $exception = null): ?array
    {
        if (null === $exception) {
            return null;
        }

        return [
            'message' => $exception->getMessage(),
            'type' => get_class($exception),
            'previous' => $this->exceptionToArray($exception->getPrevious()),
        ];
    }

    /**
     * @param       $result
     * @param int   $responseCode
     * @param array $responseHeaders
     *
     * @return Response
     */
    public function getResponse($result, int $responseCode, array $responseHeaders): Response
    {
        $response = new Response(
            $result ? $this->serialize($result) : '',
            $responseCode,
            array_merge(
                $responseHeaders,
                [
                    'Content-Type' => 'application/json',
                ]
            )
        );
        return $response;
    }

    /**
     * This will return a response with code 400. Usage example:
     *     return $this->createBadRequestResponse('Unable to access this page!');
     *
     * @param string $message A message
     *
     * @return Response
     */
    public function createBadRequestResponse($message = 'Bad Request.'): Response
    {
        return new Response($message, 400);
    }
}