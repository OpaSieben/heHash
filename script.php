<?php

//$a = "1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75";
//$b = "5267768822ee624d48fce15ec5ca79cbd602cb7f4c2157a516556991f22ef8c7b5ef7b18d1ff41c59370efb0858651d44a936c11b7b144c48fe04df3c6a3e8da";
//$c = "acc28db2beb7b42baa1cb0243d401ccb4e3fce44d7b02879a52799aadff541522d8822598b2fa664f9d5156c00c924805d75c3868bd56c2acb81d37e98e35adc";
//$d = "48fb10b15f3d44a09dc82d02b06581e0c0c69478c9fd2cf8f9093659019a1687baecdbb38c9e72b12169dc4148690f87467f9154f5931c5df665c6496cbfd5f5";
//
//$orgs = [$a, $b, $c, $d];
//
//$as = "2552d46012e2cee9c48f2238b10ec560";
//$bs = "580b7ef5583b650e55788477165ecbcf";
//$cs = "da1b8782a23ed2c5d041cc218b952631";
//$ds = "ad50cdc041f4001d08766c78548a54bc";
//
//$shorts = [$as, $bs, $cs, $ds];
//
//for ($k = 0; $k < strlen($as); $k++) { // shorts
//    for ($i = 0; $i < strlen($a); $i++) { // orgs
//        if (substrRow($orgs, $i) === substrRow($shorts, $k)) {
//            echo $i . ",";
//        }
//    }
//}
//
//function substrRow($array, $index)
//{
//
//    $output = "";
//    foreach ($array as $item) {
//        $output .= substr($item, $index, 1);
//    }
//
//    return $output;
//
//}


$originals = [
    "87017a3ffc7bdd5dc5d5c9c348ca21c5",
    "ff17891414f7d15aa4719689c44ea039",
    "5b9ea4569ad68b85c7230321ecda3780",
    "6ad211c3f933df6e5569adf21d261637"

];

/*
 *
 *  Result:
!!!! - 12345678 = 6ad211c3f933df6e5569adf21d261637
!!!! - Cleveland = ff17891414f7d15aa4719689c44ea039
!!!! - benchmark = 5b9ea4569ad68b85c7230321ecda3780
!!!! - Prodigy = 87017a3ffc7bdd5dc5d5c9c348ca21c5
 *
 */

// new hash function
function bob512($input)
{

    $order = [65, 17, 115, 31, 45, 11, 67, 92, 0, 7, 123, 37, 5, 22, 87, 124, 25, 89, 38, 61, 90, 109, 63, 28, 102, 12, 47, 59, 110, 86, 24, 18];
    $hash = hash("sha512", $input);
    $output = "";
    foreach ($order as $index) {
        $output .= substr($hash, $index, 1);
    }
    return $output;
}

foreach (scandir("pw") as $filename) {
    if ($filename === "." || $filename === "..")
        continue;

    echo "new file: " . $filename . "\n";
    $handle = fopen("pw/" . $filename, "r");
    $count = 0;
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            $hash = bob512($line);

            foreach ($originals as $original)
                if ($original === $hash) {
                    echo "!!!! - " . $line . " = " . $hash . "\n";
                }
        }
    }
    fclose($handle);
}






