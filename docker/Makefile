ifeq  ($(shell uname),Darwin)
COMPOSE:=@$(COMPOSE) -f docker-compose.macos.volume.yml
endif

activate-nfs-for-mac:
	chmod +x docker/nfs-activator.sh
	./docker/nfs-activator.sh