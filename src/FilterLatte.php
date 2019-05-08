<?php declare(strict_types=1);

namespace Filters;

use DateTime;
use Exception;
use Nette\Neon\Neon;
use Nette\SmartObject;
use Nette\Utils\Json;
use Nette\Utils\JsonException;


/**
 * Class FilterLatte
 *
 * @author geniv
 * @package Filters
 */
class FilterLatte
{
    use SmartObject;


    /**
     * _loader.
     *
     * @param string $filter
     * @param        $value
     * @return mixed
     */
    public static function _loader(string $filter, $value)
    {
        if (method_exists(__CLASS__, $filter)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array([__CLASS__, $filter], $args);
        }
        return null;
    }


    /**
     * Add tag.
     *
     * @param string $string
     * @param string $tag
     * @return string
     */
    public static function addTag(string $string, string $tag): string
    {
        $lastPoint = strrpos($string, '.');
        return ($tag ? substr_replace($string, sprintf('.%s.', $tag), $lastPoint, 1) : $string);
    }


    /**
     * Mailto.
     *
     * @param string|null $string
     * @return string
     */
    public static function mailto(string $string = null): string
    {
        return ($string ? '<a href="mailto:' . str_replace('@', '%40', $string) . '">' . str_replace('@', '&#064;', $string) . '</a>' : '');
    }


    /**
     * Date diff.
     *
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @param string        $format
     * @return string
     * @throws Exception
     */
    public static function dateDiff(DateTime $from = null, DateTime $to = null, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$from) {
            return '';
        }
        if (!$to) { // if not define to then to date is set today
            $to = new DateTime();
        }
        return $from->diff($to)->format($format);
    }


    /**
     * Czech day.
     *
     * @param DateTime $date
     * @return string
     */
    public static function czechDay(DateTime $date): string
    {
        $days = ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'];
        return $days[$date->format('w')] ?? '';
    }


    /**
     * Czech month.
     *
     * @param DateTime $date
     * @param bool     $standard
     * @return string
     */
    public static function czechMonth(DateTime $date, $standard = true): string
    {
        $monthStd = [1 => 'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];
        $monthMod = [1 => 'ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'];
        return ($standard ? $monthStd : $monthMod)[$date->format('n')] ?? '';
    }


    /**
     * Czech name day.
     *
     * @param DateTime $date
     * @return string
     */
    public static function czechNameDay(DateTime $date): string
    {
        $names = [
            //leden
            ['Nový rok', 'Karina', 'Radmila', 'Diana', 'Dalimil',
             'Tři králové', 'Vilma', 'Čestmír', 'Vladan', 'Břetislav',
             'Bohdana', 'Pravoslav', 'Edita', 'Radovan', 'Alice',
             'Ctirad', 'Drahoslav', 'Vladislav', 'Doubravka', 'Ilona',
             'Běla', 'Slavomír', 'Zdeněk', 'Milena', 'Miloš', 'Zora',
             'Ingrid', 'Otýlie', 'Zdislava', 'Robin', 'Marika'],
            //unor
            ['Hynek', 'Nela/Hromnice', 'Blažej', 'Jarmila', 'Dobromila',
             'Vanda', 'Veronika', 'Milada', 'Apolena', 'Mojmír',
             'Božena', 'Slavěna', 'Věnceslav', 'Valentýn', 'Jiřina',
             'Ljuba', 'Miloslava', 'Gizela', 'Patrik', 'Oldřich',
             'Lenka', 'Petr', 'Svatopluk', 'Matěj', 'Liliana',
             'Dorota', 'Alexandr', 'Lumír', 'Horymír'],
            //brezen
            ['Bedřich', 'Anežka', 'Kamil', 'Stela', 'Kazimír',
             'Miroslav', 'Tomáš', 'Gabriela', 'Františka', 'Viktorie',
             'Anděla', 'Řehoř', 'Růžena', 'Rút/Matylda', 'Ida',
             'Elena/Herbert', 'Vlastimil', 'Eduard', 'Josef', 'Světlana',
             'Radek', 'Leona', 'Ivona', 'Gabriel', 'Marián',
             'Emanuel', 'Dita', 'Soňa', 'Taťána', 'Arnošt',
             'Kvido'],
            //duben
            ['Hugo', 'Erika', 'Richard', 'Ivana', 'Miroslava',
             'Vendula', 'Heřman/Hermína', 'Ema', 'Dušan', 'Darja',
             'Izabela', 'Julius', 'Aleš', 'Vincenc', 'Anastázie',
             'Irena', 'Rudolf', 'Valérie', 'Rostislav', 'Marcela',
             'Alexandra', 'Evženie', 'Vojtěch', 'Jiří', 'Marek',
             'Oto', 'Jaroslav', 'Vlastislav', 'Robert', 'Blahoslav'],
            //kveten
            ['Svátek práce', 'Zikmund', 'Alexej', 'Květoslav', 'Klaudie, Květnové povstání českého lidu',
             'Radoslav', 'Stanisla', 'Den osvobození od fašismu', 'Ctibor', 'Blažena',
             'Svatava', 'Pankrác', 'Servác', 'Bonifác', 'Žofie',
             'Přemysl', 'Aneta', 'Nataša', 'Ivo', 'Zbyšek',
             'Monika', 'Emil', 'Vladimír', 'Jana', 'Viola',
             'Filip', 'Valdemar', 'Vilém', 'Maxmilián', 'Ferdinand',
             'Kamila'],
            //cerven
            ['Laura', 'Jarmil', 'Tamara', 'Dalibor', 'Dobroslav',
             'Norbert', 'Iveta/Slavoj', 'Medard', 'Stanislav', 'Gita',
             'Bruno', 'Antonie', 'Antonín', 'Roland', 'Vít',
             'Zbyněk', 'Adolf', 'Milan', 'Leoš', 'Květa',
             'Alois', 'Pavla', 'Zdeňka', 'Jan', 'Ivan',
             'Adriana', 'Ladislav', 'Lubomír', 'Petr a Pavel', 'Šárka'],
            //cervenec
            ['Jaroslava', 'Patricie', 'Radomír', 'Prokop', 'Den slovanských věrozvěstů Cyrila a Metoděje',
             'Upálení mistra Jana Husa', 'Bohuslava', 'Nora', 'Drahoslava', 'Libuše/Amálie',
             'Olga', 'Bořek', 'Markéta', 'Karolína', 'Jindřich',
             'Luboš', 'Martina', 'Drahomíra', 'Čeněk', 'Ilja',
             'Vítězslav', 'Magdeléna', 'Libor', 'Kristýna', 'Jakub',
             'Anna', 'Věroslav', 'Viktor', 'Marta', 'Bořivoj',
             'Ignác'],
            //srpen
            ['Oskar', 'Gustav', 'Miluše', 'Dominik', 'Kristián',
             'Oldřiška', 'Lada', 'Soběslav', 'Roman', 'Vavřinec',
             'Zuzana', 'Klára', 'Alena', 'Alan', 'Hana',
             'Jáchym', 'Petra', 'Helena', 'Ludvík', 'Bernard',
             'Johana', 'Bohuslav', 'Sandra', 'Bartoloměj', 'Radim',
             'Luděk', 'Otakar', 'Augustýn', 'Evelína', 'Vladěna',
             'Pavlína'],
            //zari
            ['Linda/Samuel', 'Adéla', 'Bronislav', 'Jindřiška', 'Boris',
             'Boleslav', 'Regína', 'Mariana', 'Daniela', 'Irma',
             'Denisa', 'Marie', 'Lubor', 'Radka', 'Jolana',
             'Ludmila', 'Naděžda', 'Kryštof', 'Zita', 'Oleg',
             'Matouš', 'Darina', 'Berta', 'Jaromír', 'Zlata',
             'Andrea', 'Jonáš', 'Václav, Den české státnosti', 'Michal', 'Jeroným'],
            //rijen
            ['Igor', 'Olívie', 'Bohumil', 'František', 'Eliška',
             'Hanuš', 'Justýna', 'Věra', 'Štefan/Sára', 'Marina',
             'Andrej', 'Marcel', 'Renáta', 'Agáta', 'Tereza',
             'Havel', 'Hedvika', 'Lukáš', 'Michaela', 'Vendelín',
             'Brigita', 'Sabina', 'Teodor', 'Nina', 'Beáta',
             'Erik', 'Šarlota/Zoe', 'Den vzniku samostatného československého státu', 'Silvie', 'Tadeáš',
             'Štěpánka'],
            //listopad
            ['Felix', 'Památka zesnulých', 'Hubert', 'Karel', 'Miriam',
             'Liběna', 'Saskie', 'Bohumír', 'Bohdan', 'Evžen',
             'Martin', 'Benedikt', 'Tibor', 'Sáva', 'Leopold',
             'Otmar', 'Mahulena, Den boje studentů za svobodu a demokracii', 'Romana', 'Alžběta', 'Nikola',
             'Albert', 'Cecílie', 'Klement', 'Emílie', 'Kateřina',
             'Artur', 'Xenie', 'René', 'Zina', 'Ondřej'],
            //prosinec
            ['Iva', 'Blanka', 'Svatoslav', 'Barbora', 'Jitka',
             'Mikuláš', 'Ambrož/Benjamín', 'Květoslava', 'Vratislav', 'Julie',
             'Dana', 'Simona', 'Lucie', 'Lýdie', 'Radana',
             'Albína', 'Daniel', 'Miloslav', 'Ester', 'Dagmar',
             'Natálie', 'Šimon', 'Vlasta', 'Adam a Eva, Štědrý den', 'Boží hod vánoční - svátek vánoční',
             'Štěpán - svátek vánoční', 'Žaneta', 'Bohumila', 'Judita', 'David',
             'Silvestr - Nový rok'],
        ];
        return $names[$date->format('n') - 1][$date->format('j') - 1] ?? '';
    }


    /**
     * Chmod text.
     *
     * @param string $file
     * @return string
     */
    public static function chmodText(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        $perms = fileperms($file);
        if (($perms & 0xC000) == 0xC000) {
            // Socket
            $result = 's';
        } elseif (($perms & 0xA000) == 0xA000) {
            // Symbolic Link
            $result = 'l';
        } elseif (($perms & 0x8000) == 0x8000) {
            // Regular
            $result = '-';
        } elseif (($perms & 0x6000) == 0x6000) {
            // Block special
            $result = 'b';
        } elseif (($perms & 0x4000) == 0x4000) {
            // Directory
            $result = 'd';
        } elseif (($perms & 0x2000) == 0x2000) {
            // Character special
            $result = 'c';
        } elseif (($perms & 0x1000) == 0x1000) {
            // FIFO pipe
            $result = 'p';
        } else {
            // Unknown
            $result = 'u';
        }
        // Owner
        $result .= (($perms & 0x0100) ? 'r' : '-');
        $result .= (($perms & 0x0080) ? 'w' : '-');
        $result .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x') :
            (($perms & 0x0800) ? 'S' : '-'));
        // Group
        $result .= (($perms & 0x0020) ? 'r' : '-');
        $result .= (($perms & 0x0010) ? 'w' : '-');
        $result .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x') :
            (($perms & 0x0400) ? 'S' : '-'));
        // World
        $result .= (($perms & 0x0004) ? 'r' : '-');
        $result .= (($perms & 0x0002) ? 'w' : '-');
        $result .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x') :
            (($perms & 0x0200) ? 'T' : '-'));
        return $result;
    }


    /**
     * Chmod octal.
     *
     * @param string $file
     * @return string
     */
    public static function chmodOctal(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        return substr(sprintf('%o', fileperms($file)), -4);
    }


    /**
     * Is readable.
     *
     * @param string $file
     * @return string
     */
    public static function readable(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        return strval(is_readable($file));
    }


    /**
     * Is writable.
     *
     * @param string $file
     * @return string
     */
    public static function writable(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        return strval(is_writable($file));
    }


    /**
     * Is executable.
     *
     * @param string $file
     * @return string
     */
    public static function executable(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        return strval(is_executable($file));
    }


    /**
     * File modify time.
     *
     * @param string $file
     * @return string
     */
    public static function mtime(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }
        return (string) filemtime($file);
    }


    /**
     * Google maps link.
     *
     * @see https://developers.google.com/maps/documentation/urls/guide
     * @param string $query
     * @return string
     */
    public static function googleMapsLink(string $query): string
    {
        $result = $query;
        if ($query) {
            $result = 'https://www.google.com/maps/search/?api=1&query=' . $query;
        }
        return $result;
    }


    /**
     * To url.
     *
     * @param string $url
     * @param string $scheme
     * @return string
     */
    public static function toUrl(string $url, string $scheme = 'http://'): string
    {
        $http = preg_match('/^http[s]?:\/\//', $url);
        return (!$http ? $scheme : '') . $url;
    }


    /**
     * Real url.
     *
     * @param string $value
     * @return string
     */
    public static function realUrl(string $value): string
    {
        list($scheme, $url) = explode('//', $value);
        $reverse = explode('/', $url);
        $arr = [];
        foreach ($reverse as $item) {
            $arr[] = $item;
            if ($item == '..') {
                array_pop($arr);    // remove 2x from array stack
                array_pop($arr);
            }
        }
        return $scheme . '//' . implode('/', $arr);
    }


    /**
     * Neon.
     *
     * @see https://github.com/planette/nutella-project/blob/master/app/model/Latte/Filters.php
     * @param $value
     * @return string
     */
    public static function neon($value): string
    {
        return Neon::encode($value, Neon::BLOCK);
    }


    /**
     * Json.
     *
     * @param $value
     * @return string
     * @throws JsonException
     */
    public static function json($value): string
    {
        return Json::encode($value);
    }
}
