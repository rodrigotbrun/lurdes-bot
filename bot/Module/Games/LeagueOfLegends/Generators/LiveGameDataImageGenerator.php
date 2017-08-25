<?php

namespace LurdesBot\Games\LeagueOfLegends\Generators;

use LurdesBot\Games\LeagueOfLegends\Entity\Champion;
use LurdesBot\Games\LeagueOfLegends\Entity\Rune;
use LurdesBot\Games\LeagueOfLegends\Entity\Spell;
use LurdesBot\Games\LeagueOfLegends\RiotApi;

class LiveGameDataImageGenerator {

    const ALLY_TEAM = 100;
    const ENEMY_TEAM = 200;

    private $gameLiveData;
    private $image;
    private $summonerId;
    private $style = [
        'columnWidth' => 480,
        'rowHeight' => 260,
        'color' => [],
        'images' => [
            'champions' => [
                'splashart' => [
                    'path' => __DIR__ . '/assets/champions/splashart/',
                    'extension' => 'jpg',
                ],
                'icon' => [
                    'path' => __DIR__ . '/assets/champions/icon/',
                    'extension' => 'png',
                ],
                'loading' => [
                    'path' => __DIR__ . '/assets/champions/loading/',
                    'extension' => 'jpg',
                ],
            ],
            'summoners' => [
                'icon' => [
                    'path' => __DIR__ . '/assets/summoners/icon/',
                    'extension' => 'jpg',
                ],
            ],
            'spells' => [
                'icon' => [
                    'path' => __DIR__ . '/assets/spells/',
                    'extension' => 'png',
                ],
            ],
            'ranked-tiers' => [
                'icon' => [
                    'path' => __DIR__ . '/assets/ranked-tier/',
                    'extension' => 'png',
                ],
            ]
        ],
        'fonts' => [
            'arial' => __DIR__ . '/assets/fonts/arial.ttf',
            'roboto' => __DIR__ . '/assets/fonts/Roboto-Regular.ttf',
            'robotoMedium' => __DIR__ . '/assets/fonts/Roboto-Medium.ttf',
            'robotoBold' => __DIR__ . '/assets/fonts/Roboto-Bold.ttf',
        ],
        'font' => 'robotoBold'
    ];

    /**
     * LiveGameDataImageGenerator constructor.
     * @param $gameLiveData
     */
    public function __construct($summonerId, $gameLiveData) {
        $this->gameLiveData = $gameLiveData;
        $this->summonerId = $summonerId;
    }

    public function buildImage() {
        $HEIGHT = $this->style['rowHeight'] * 5;
        $this->image = imagecreatetruecolor($this->style['columnWidth'] * 2, $HEIGHT);
        $this->style['color']['black'] = imagecolorallocate($this->image, 0, 0, 0);
        $this->style['color']['white'] = imagecolorallocate($this->image, 255, 255, 255);
        $this->style['color']['blue'] = imagecolorallocate($this->image, 0, 124, 233);
        $this->style['color']['red'] = imagecolorallocate($this->image, 239, 75, 51);
        $this->style['color']['yellow'] = imagecolorallocate($this->image, 239, 219, 30);
        $this->style['color']['blue_overlay'] = imagecolorallocatealpha($this->image, 0, 124, 233, 110);
        $this->style['color']['red_overlay'] = imagecolorallocatealpha($this->image, 239, 75, 51, 110);
        $this->style['color']['black_overlay'] = imagecolorallocatealpha($this->image, 0, 0, 0, 45);
        $this->style['color'][self::ALLY_TEAM] = $this->style['color']['blue'];
        $this->style['color'][self::ENEMY_TEAM] = $this->style['color']['red'];

        // Separa os dados do livegame entre aliado e inimigo
        $liveData = [
            self::ALLY_TEAM => [],
            self::ENEMY_TEAM => [],
        ];

        if (isset($this->gameLiveData->participants) && count($this->gameLiveData->participants) > 0) {
            foreach ($this->gameLiveData->participants as $s) {
                $liveData[$s->teamId][] = $s;
            }
        }

        // Overlay times cores
        foreach ($liveData as $team => $data) {
            foreach ($data as $index => $info) {
                $liveData[$team][$index]->champion = Champion::find($info->championId);
                $liveData[$team][$index]->spell1 = Spell::find($info->spell1Id);
                $liveData[$team][$index]->spell2 = Spell::find($info->spell1Id);
                $liveData[$team][$index]->runesDetails = [];

                if (isset($info->runes) && count($info->runes) > 0) {
                    $i = 0;
                    foreach ($info->runes as $r) {
                        $liveData[$team][$index]->runesDetails[$i] = Rune::find($r->runeId);
                        $value = (float)$liveData[$team][$index]->runesDetails[$i]->stats_value;
                        $liveData[$team][$index]->runesDetails[$i]['total_benefits'] = $value * $r->count;
                        $liveData[$team][$index]->runesDetails[$i]['count'] = $r->count;
                        $liveData[$team][$index]->runesDetails[$i]['benefit_name'] = lang($liveData[$team][$index]->runesDetails[$i]->stats_key);
                        $i++;
                    }
                }

                $this->addBackgrounds($info, $index, $team);
            }
        }

        imagefilledrectangle($this->image, 0, 0, $this->style['columnWidth'] * 2, $HEIGHT, $this->style['color']['black_overlay']);
        imagefilledrectangle($this->image, 0, 0, $this->style['columnWidth'], $HEIGHT, $this->style['color']['blue_overlay']);
        imagefilledrectangle($this->image, $this->style['columnWidth'], 0, $this->style['columnWidth'] * 2, $HEIGHT, $this->style['color']['red_overlay']);

        for ($i = 0; $i <= 5; $i++) {
            imagerectangle($this->image,
                0, $this->style['rowHeight'] * $i,
                $this->style['columnWidth'], $this->style['rowHeight'],
                $this->style['color']['blue']);
        }

        for ($i = 0; $i <= 5; $i++) {
            imagerectangle($this->image,
                $this->style['columnWidth'], $this->style['rowHeight'] * $i,
                $this->style['columnWidth'] * 2 - 1, $this->style['rowHeight'],
                $this->style['color']['red']);
        }

        imageline($this->image, 0, $HEIGHT - 1, $this->style['columnWidth'], $HEIGHT - 1, $this->style['color']['blue']);
        imageline($this->image, $this->style['columnWidth'], $HEIGHT - 1, $this->style['columnWidth'] * 2, $HEIGHT - 1, $this->style['color']['red']);


        for ($i = 0; $i <= 6; $i++) {
            imageline($this->image, 0 + $i, 0, 0 + $i, $HEIGHT, $this->style['color']['blue']);
        }

        for ($i = $this->style['columnWidth']; $i <= $this->style['columnWidth'] + 6; $i++) {
            imageline($this->image, 0 + $i, 0, 0 + $i, $HEIGHT, $this->style['color']['red']);
        }

        /////////////////// FILL LIVE GAME INFO ///////////////////////
        foreach ($liveData as $team => $data) {
            foreach ($data as $index => $info) {
                $this->addSummonerInfo($info, $index, $team);
            }
        }

    }

    ///////// Render Style for ALLY
    private function addSummonerInfo($info, $index, $team) {
        $x = $this->teamXStart($team);
        $profileIconSize = 40;
        $padding = 20;

        imagerectangle($this->image,
            $x + $padding, $this->style['rowHeight'] * $index + 15,
            $x + $padding + $profileIconSize, $this->style['rowHeight'] * $index + 15 + $profileIconSize,
            $this->style['color'][$team]
        );

        $this->placeImage(
            $this->lolImageAsset($info->profileIconId, 'summoners', 'icon'),
            $padding, $this->style['rowHeight'] * $index + 15,
            $profileIconSize, $profileIconSize,
            $team,
            true
        );

        imagerectangle($this->image,
            $x + 19, $this->style['rowHeight'] * $index + 14,
            $x + $padding + $profileIconSize + 1, $this->style['rowHeight'] * $index + 15 + $profileIconSize + 1,
            $this->style['color'][$team]
        );

        imagettftext($this->image,
            15, 0,
            $x + $padding + $profileIconSize + 16, $this->style['rowHeight'] * $index + 43,
            $this->style['color']['white'],
            $this->style['fonts'][$this->style['font']],
            $info->summonerName
        );

        /////////////////////////////////////////////////

        $this->placeImage(
            $this->lolImageAsset($info->spell1->image, 'spells', 'icon'),
            $padding,
            $this->style['rowHeight'] * $index + 214,
            30, 30,
            $team,
            true
        );

        $this->placeImage(
            $this->lolImageAsset($info->spell2->image, 'spells', 'icon'),
            $padding + $profileIconSize - 2,
            $this->style['rowHeight'] * $index + 214,
            30, 30,
            $team,
            true
        );

        ///////
        $txtSize = 9;
        imagettftext($this->image,
            $txtSize, 0,
            $x + $padding,
            $this->style['rowHeight'] * $index + ($this->style['rowHeight'] / 1.3) + 4,
            $this->style['color']['yellow'],
            $this->style['fonts']['robotoBold'],
            'Feitiços'
        );

        imagettftext($this->image,
            $txtSize, 0,
            $x + $padding + $profileIconSize + $profileIconSize + 5 + $padding,
            $this->style['rowHeight'] * $index + ($this->style['rowHeight'] / 1.3) + 4,
            $this->style['color']['yellow'],
            $this->style['fonts']['robotoBold'],
            'Talento'
        );


        ///// Runas

        imagettftext($this->image,
            $txtSize, 0,
            $x + $padding, $this->style['rowHeight'] * $index + (76),
            $this->style['color']['yellow'],
            $this->style['fonts']['robotoBold'],
            'Runas'
        );

        if (count($info->runesDetails) > 0) {
            $runeTextSize = 9;
            $lineHeight = 15;
            $lineStart = $this->style['rowHeight'] * $index + (94);
            $leftStart = $x + $padding + 5;

            foreach ($info->runesDetails as $inr => $r) {
                $bn = number_format($r['total_benefits'], 2, '.', '');
                if ($bn > 0.0) $bn = " +{$bn}";

                imagettftext($this->image,
                    $runeTextSize, 0,
                    $leftStart, $lineStart,
                    $this->style['color']['white'],
                    $this->style['fonts']['robotoMedium'],
                    "{$bn} de {$r['benefit_name']}"
                );

                if ((($inr + 1) % 7) === 0) {
                    $lineStart = $this->style['rowHeight'] * $index + (92);
                    $leftStart += 220;
                } else {
                    $lineStart += $lineHeight;
                }
            }

        } else {
//            $runesText = 'Não tem 😱';
        }

        /////////// Ranked status

        $this->placeImage(
            $this->style['images']['ranked-tiers']['icon']['path'] . 'provisional.png',
            $this->style['columnWidth'] - 85,
            $this->style['rowHeight'] * $index + ($this->style['rowHeight'] / 1.3) - 36,
            80, 80,
            $team,
            false
        );

        imagettftext($this->image,
            8, 0,
            $x + $this->style['columnWidth'] - 71,
            $this->style['rowHeight'] * $index + ($this->style['rowHeight'] / 1.3) + 44,
            $this->style['color']['white'],
            $this->style['fonts']['roboto'],
            'Unranked'
        );
    }

    private function placeImage($image, $xPos, $yPos, $width, $height, $team, $border = true) {
        $x = $this->teamXStart($team);
        $iconSummonerComponent = imagecreatefrompng($image);
        list($iconSourceW, $iconSourceH) = getimagesize($image);

        imagecopyresampled($this->image,
            $iconSummonerComponent,
            $x + $xPos, $yPos, 0, 0,
            $width, $height,
            $iconSourceW, $iconSourceH
        );

        if ($border) {
            imagerectangle($this->image,
                $x + $xPos, $yPos,
                $x + $xPos + $width, $yPos + $height,
                $this->style['color'][$team]
            );
        }
    }

    private function addBackgrounds($info, $index, $team) {
        $splashArtChampion = $this->lolImageAsset($info->champion->champ_key, 'champions', 'splashart');
        $splashArtChampionComponent = imagecreatefromjpeg($splashArtChampion);
        $x = $this->teamXStart($team);;

        list($sourceW, $sourceH) = getimagesize($splashArtChampion);
        imagecopyresampled($this->image,
            $splashArtChampionComponent,
            $x, $this->style['rowHeight'] * $index, 0, 0,
            $this->style['columnWidth'], $this->style['rowHeight'],
            $sourceW, $sourceH
        );
    }

    public function render() {
        $filename = 'gg-' . $this->summonerId . '-' . time() . '.png';
        $file = base_path('storage/generated/' . $filename);
        imagepng($this->image, $file);
        return $file;
    }

    private function lolImageAsset($champKey, $group = 'champions', $kind = 'icon') {
        $path = $this->style['images'][$group][$kind]['path'];
        $localChampImage = $path . $champKey . '.' . $this->style['images'][$group][$kind]['extension'];
        if (file_exists($localChampImage)) {

            return $localChampImage;
        } else {
            $lolv = CONFIG['lol_version'];

            switch ($group . $kind) {
                case 'championssplashart':
                    $remoteImage = "http://ddragon.leagueoflegends.com/cdn/img/champion/splash/{$champKey}_0.jpg";
                    break;
                case 'championsicon':
                    $remoteImage = "http://ddragon.leagueoflegends.com/cdn/{$lolv}/img/champion/{$champKey}.png";
                    break;
                case 'championsloading':
                    $remoteImage = "http://ddragon.leagueoflegends.com/cdn/img/champion/loading/{$champKey}_0.jpg";
                    break;
                case 'summonersicon':
                    $remoteImage = "http://ddragon.leagueoflegends.com/cdn/{$lolv}/img/profileicon/{$champKey}.png";
                    break;
                case 'spellsicon':
                    $remoteImage = "http://ddragon.leagueoflegends.com/cdn/{$lolv}/img/spell/{$champKey}";
                    break;
            }

            shell_exec('curl -X GET "' . $remoteImage . '" > "' . $localChampImage . '"');
            if (file_exists($localChampImage))
                return $this->lolImageAsset($champKey, $group, $kind);
        }
    }

    private function teamXStart($team) {
        return $this->style['columnWidth'] * (($team / 100) - 1);
    }

}