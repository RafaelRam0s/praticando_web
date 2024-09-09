<?php 

function pegar_chaves($array, $prefix = '') {
    $keys = [];
    foreach ($array as $key => $value) {
        $fullKey = $prefix === '' ? $key : $prefix . '.' . $key;
        $keys[] = $fullKey;
        if (is_array($value)) {
            $keys = array_merge($keys, pegar_chaves($value, $fullKey));
        }
    }
    return $keys;
}

function estruturas_de_array_iguais($array1, $array2) {
    $keys1 = pegar_chaves($array1);
    $keys2 = pegar_chaves($array2);
    
    sort($keys1);
    sort($keys2);
    
    return $keys1 === $keys2;
}

// Exemplos de uso
/*
    $array1 = [
        'name' => null,
        'address' => [
            'street' => null,
            'city' => null
        ],
        'age' => null,
        'teste',
        10
    ];

    $array2 = [
        'age' => 30,
        'address' => [
            'street' => '456 Elm St',
            'city' => 'Nowhere'
        ],
        'name' => 'Bob',
        'ae suceso no teste',
        11
    ];

    $array3 = [
        'não suceso no teste',
        'age' => 30,
        'address' => [
            'street' => '456 Elm St',
            'city' => 'Nowhere'
        ],
        'name' => 'Bob',
        11
    ];

    echo estruturas_de_array_iguais($array1, $array2) ? 'Same structure' : 'Different structure'; // Same structure
    echo "\n";
    echo estruturas_de_array_iguais($array1, $array3) ? 'Same structure' : 'Different structure'; // Different structure
*/
?>