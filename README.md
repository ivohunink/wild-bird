## Wild bird (wild-bird)

Wild bird is a personal home-automation project written in PHP.

## Installation

TODO: Describe the installation process

## Usage

TODO: Finalize usage instructions
1. Install and configure Pimatic
2. Download wild-bird (git clone https://github.com/ivohunink/wild-bird)
3. Download and install Composer (https://getcomposer.org/doc/00-intro.md) and run "composer install" to download wild-bird's dependencies
2. Copy wildbird/config/config.dist.json to wildbird/config/config.json
3. Add Pimatic API details in config.json
4. Add the switch and dim lights you want to control to the config.json configuration file
5. ... Something about IFTTT

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request
6. Done!

## History

2017/04/14. Initial version.

## Credits

Ivo Hunink

## License

The MIT License.

## Roadmap

- Validate config.json configuration file before starting
- Proper logging
- Add unit testing
- Add config.dist.json
- Move Pimatic API details to config.json
- Add PushBullet for logging
- Fix logging in CURL call (currently, it continues even after CURL fails)
- Pass back errors up the chain from PimaticDevice to AbstractLight to WildBird
