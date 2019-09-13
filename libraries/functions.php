<?php
// Supprime le dossier selectionné ainsi que tout les sous dossiers et fichiers à l'interieur
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function isInteger($input)
{
    return (ctype_digit(strval($input)));
}
