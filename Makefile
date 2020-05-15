# Setup the project and migrate the database, you may have to add a "dovu_scooter" db
create:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate
	# attempt to create "dovu_scooter" database
	mysql -u root -e 'create database if not exists dovu_scooter' || true
	php artisan migrate

start:
	php artisan serve

# Use this on a different tab to provide a endpoint URL for your local env for the client callback
expose:
	ngrok http 8000
	# Alternatively use "localhost.run"
	# ssh -R 80:localhost:8000 ssh.localhost.run
