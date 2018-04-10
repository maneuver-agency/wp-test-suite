## Installing

Install with composer.

```
composer require --dev maneuver/wp-test-suite
```

Run this script to copy some necessary files and example tests.

```
composer run-script copy-files -d ./vendor/maneuver/wp-test-suite
```


## Usage

Create your tests inside the ./tests/ folder.  

Then use phpunit to run all defined tests:

```
./vendor/bin/phpunit
```

Or one specific test:

```
./vendor/bin/phpunit ./tests/BrowserTest.php
```

---

For browser tests first run Chrome in headless mode in a seperate terminal window.

```
/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --disable-gpu --headless --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222
```

Or Chrome Canary:

```
/Applications/Google\ Chrome\ Canary.app/Contents/MacOS/Google\ Chrome\ Canary --disable-gpu --headless --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222
```