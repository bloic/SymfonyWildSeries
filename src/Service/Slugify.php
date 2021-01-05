<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {
        $input = strtr(utf8_decode($input),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $input = preg_replace('/[\.\,\/\#\!\$\%\\\\&\*\;\:\{\}\=\_\`\+\~\-{2}\?\(\)]+/','',$input);
        return  str_replace(' ','-',trim(mb_strtolower($input)));
    }
}