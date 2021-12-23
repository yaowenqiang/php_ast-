<?php
    $fileName = file("php://stdin");
    $search = $argv[1];
    foreach($fileName as $file) {
        $file = trim($file);
        $fileStr = file_get_contents($file);
        $newStr = '';
        $commentTokens = [T_COMMENT];
        if (defined('T_DOC_COMMENT')) {
            $commentTokens[] = T_DOC_COMMENT;
        }

        if (defined('T_ML_COMMENT')) {
            $commentTokens[] = T_ML_COMMENT;
        }

        $tokens = token_get_all($fileStr);

        foreach($tokens as $token) {
            if (is_array($token))  {
                if(in_array($token[0], $commentTokens)) {
                    continue;
                }
                $token = $token[1];
            }
            $newStr .= $token;
        }
        preg_match_all("/$search/", $newStr,$matches);
        if ($matches) {
            echo "$file contains $search.\n";
            print_r($matches);
        }
    }

?>
