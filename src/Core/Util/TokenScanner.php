<?php

namespace Pars\Core\Util;

use function count;
use function defined;
use function feof;
use function fgets;
use function file_exists;
use function fopen;
use function is_array;
use function ltrim;
use function str_contains;
use function token_get_all;
use function trim;

class TokenScanner
{
    public function getClassNameFromFile(string $file): ?string
    {
        if (!file_exists($file)) {
            return null;
        }

        $fp = fopen($file, 'r');

        if (false === $fp) {
            return null;
        }

        $class = $namespace = $buffer = '';
        $i = 0;

        while (!$class) {
            if (feof($fp)) {
                break;
            }

            // Read entire lines to prevent keyword truncation
            for ($line = 0; $line <= 20; $line++) {
                $buffer .= fgets($fp);
            }
            $tokens = @token_get_all($buffer);

            if (!str_contains($buffer, '{')) {
                continue;
            }

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        $tokenId = $tokens[$j][0];
                        $namespaceToken = defined('T_NAME_QUALIFIED') ? T_NAME_QUALIFIED : T_STRING;

                        if ($tokenId === T_STRING || $tokenId === $namespaceToken) {
                            $namespace .= '\\' . $tokens[$j][1];
                        } elseif ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }

                if ($this->isClassLike($tokens[$i])) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j][0] === T_STRING) {
                            $class = $tokens[$i + 2][1];

                            break 2;
                        }
                    }
                }
            }
        }

        if (!trim($class)) {
            return null;
        }

        return ltrim($namespace . '\\' . $class, '\\');
    }

    /**
     * @param string|array<int> $token
     * @return bool
     */
    private function isClassLike(string|array $token): bool
    {
        if (!is_array($token)) {
            return false;
        }
        if ($token[0] === T_CLASS || $token[0] === T_INTERFACE || $token[0] === T_TRAIT) {
            return true;
        }

        if (!defined('T_ENUM')) {
            return false;
        }

        return $token[0] === T_ENUM;
    }
}
