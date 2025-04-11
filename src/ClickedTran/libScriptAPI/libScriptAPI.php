<?php
namespace ClickedTran\libScriptAPI;

class libScriptAPI {
  public static function runScript(string $filePath, array $vars = []): void {
    if (!file_exists($filePath)) {
        echo "Script file not found: $filePath\n";
        return;
    }

    $code = file_get_contents($filePath);
    $code = preg_replace('/^\s*<\?php/', '', $code);
      
    do {
        $oldCode = $code;
        // $a.b => $a->b
        $code = preg_replace('/((?:\$\w+|\b[a-zA-Z_][\w:]*\(\)))\.([a-zA-Z_]\w*)/', '$1->$2', $code);

    } while ($code !== $oldCode);

    $tmpFile = tempnam(sys_get_temp_dir(), "script_");
    file_put_contents($tmpFile, "<?php\n" . $code);

    extract($vars, EXTR_SKIP);

    try {
        include $tmpFile;
    } catch (\Throwable $e) {
        echo "[ScriptRunner Error] " . $e->getMessage() . "\n";
    }

    unlink($tmpFile);
  }
}
