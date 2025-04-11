<?php

namespace ClickedTran\libScriptAPI;

class libScriptAPI {
  public static function runScript(string $filePath, array $vars = [], ?object $context = null): void {
    if (!file_exists($filePath)) {
        echo "Script file not found: $filePath\n";
        return;
    }

    $code = file_get_contents($filePath);
    $code = preg_replace('/^\s*<\?php/', '', $code);
    //$code = preg_replace('/(\$\w+)\^([a-zA-Z_]\w*)/', '$1->$2', $code);
    $code = preg_replace('/(\$\w+)\.([a-zA-Z_]\w*)/', '$1->$2', $code);

    $tmpFile = tempnam(sys_get_temp_dir(), "script_");
    file_put_contents($tmpFile, "<?php\n" . $code);

    extract($vars, EXTR_SKIP);

    try {
      if ($context !== null) {
        // Tạo anonymous function trong context object
        $func = function() use ($tmpFile) {
            include $tmpFile;
        };
        $bound = $func->bindTo($context, get_class($context));
        $bound();
      } else {
        include $tmpFile;
      }
    } catch (\Throwable $e) {
        echo "[ScriptRunner Error] " . $e->getMessage() . "\n";
    }

    unlink($tmpFile);
  }
}
