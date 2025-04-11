## GENERAL
libScriptAPI for PMMP
- [x] ADD FILES WITHOUT USING NAESPACE AND CLASS
- [x] CHANGE `->` DEFAULT TO `.` (eg: $this->getServer()->getLogger()->info(...) to $this.getServer().getLogger().info(....))

## HOW TO USE
Add use:
```php
use ClickedTran\libScriptAPI\libScriptAPI
```

Use file without `namespace and class`
```php
libScriptAPI::runScript(__DIR__ . "/YOUR FILE PATH");
```

Add $player or other in `YOUR FILE PATH`
```php
libScriptAPI::runScript(__DIR__ . "/YOUR FILE PATH", [
  "player" => $player
  //other code...
  ]);
```

## TESTER PLUGIN
[Watch here](https://github.com/ClickedTran/libScriptAPIPlugin)
