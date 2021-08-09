<?php
declare(strict_types=1);

namespace App\Tests\Handler;

use App\Message\RouteMessage;
use PHPUnit\Framework\TestCase;

class CreateBookingMessageHandlerTest extends TestCase
{
    /**
     * This will test a booking being processed
     * @group time-sensitive
     * @throws \Exception
     */
    public function testProcessBooking(): void
    {
        // first we create our first booking
        $booking = new Booking('my-new-booking');
        $booking->setId(1);

        // now we pass this booking into a RouteMessage
        $routeMessage = new RouteMessage($booking->getId());

        // to mock the CreateBookingMessageHandler, we need a mock of the BookingManager
        $bookingManagerMock = $this->getMockBuilder(BookingManager::class)
            ->setMethods(['findBooking', 'processBooking']) // list of methods we would like to mock
            ->disableOriginalConstructor()
            ->getMock();

        // the $bookingManagerMock should return our booking if the method findOneById is called
        $bookingManagerMock->expects($this->once())
            ->method('findBooking')
            ->with($booking->getId())
            ->willReturn($booking);

        // we expect the processBooking method to be called on the $bookingManagerMock
        $bookingManagerMock->expects($this->once())->method('processBooking')->with($booking);

        $this->assertEquals(Booking::STATUS_NEW, $booking->getStatus());

        // we create an instance of the CreateBookingMessageHandler
        $createBookingMessageHandler = new CreateBookingMessageHandler($bookingManagerMock);

        // now we actually pass the RouteMessage to the CreateBookingMessageHandler, this works by
        // calling the CreateBookingMessageHandler as a function, which then triggers its __invoke method
        $createBookingMessageHandler($routeMessage);
    }
}