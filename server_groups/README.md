# Server Group Icons

Server group icons are disabled by default inside the [`config.php`][config].
```php
$groups = 0; // 1 = Enabled, 0 = Disabled
```

## Usage

Put your icons inside this folder and rename them by their **Group ID** number and change the file format to png. If your icons arent saved on your server you can always find them client-sided after you joined the Teamspeak 3 Server. You can find them inside the `%appdata%` folder: `TS3Client/cache/YOUR_SERVER/icons`.

## Server Group Icon ID's

Connect to your Teamspeak 3 Server and press <kbd>Ctrl</kbd> + <kbd>F1</kbd> to see all group icons on your server. Hover over the icons to reveal their permanent group ID.

[config]: https://github.com/dennisabrams/teamspeak3-banner/blob/main/config.php
