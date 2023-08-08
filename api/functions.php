<?php
// Fungsi untuk melakukan analisis leksikal
function analisisLeksikal($input)
{
    $tokens = []; // Array untuk menyimpan token-token hasil analisis leksikal

    $len = strlen($input);
    $i = 0;

    while ($i < $len) {
        $char = $input[$i];

        // Melewati spasi, tab, atau karakter yang tidak perlu dianalisis
        if ($char == ' ' || $char == '\t') {
            $i++;
            continue;
        }

        // Mengecek apakah karakter adalah angka
        if (is_numeric($char)) {
            $value = '';
            while ($i < $len && is_numeric($input[$i])) {
                $value .= $input[$i];
                $i++;
            }
            $tokens[] = ['type' => 'NUMBER', 'value' => $value];
            continue;
        }

        // Mengecek apakah karakter adalah huruf
        if (ctype_alpha($char) || $char == '$') {
            $value = '';
            while ($i < $len && (ctype_alnum($input[$i]) || $input[$i] == '$')) {
                $value .= $input[$i];
                $i++;
            }

            if (isKeyword($value)) {
                $tokens[] = ['type' => 'KEYWORD', 'value' => $value];
            } else {
                $tokens[] = ['type' => 'IDENTIFIER', 'value' => $value];
            }
            continue;
        }

        // Mengecek apakah karakter adalah tanda baca
        if (isPunctuation($char)) {
            $tokens[] = ['type' => 'PUNCTUATION', 'value' => $char];
            $i++;
            continue;
        }

        // Mengecek apakah karakter adalah operator
        if (isOperator($char)) {
            $value = '';
            while ($i < $len && isOperator($input[$i])) {
                $value .= $input[$i];
                $i++;
            }
            $tokens[] = ['type' => 'OPERATOR', 'value' => $value];
            continue;
        }

        // Jika karakter tidak cocok dengan jenis di atas, anggap sebagai literal
        $tokens[] = ['type' => 'LITERAL', 'value' => $char];
        $i++;
    }

    return $tokens;
}

// Fungsi untuk memeriksa apakah kata adalah keyword
function isKeyword($word)
{
    $keywords = ["for", "while", "if", "do", "switch", "case", "echo", "count", "FOR", "WHILE", "IF", "DO", "SWITCH", "CASE", "ECHO", "COUNT"];
    return in_array($word, $keywords);
}

// Fungsi untuk memeriksa apakah karakter adalah tanda baca
function isPunctuation($char)
{
    $punctuations = [".", ",", ";", ":", "?", "!", "(", ")", "{", "}", "[", "]", " ' ", ' " '];
    return in_array($char, $punctuations);
}

// Fungsi untuk memeriksa apakah karakter adalah operator
function isOperator($char)
{
    $operators = ["+", "-", "*", "/", "=", "==", "!=", ">=", "<=", "==="];
    return in_array($char, $operators);
}
