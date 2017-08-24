<?php

namespace LurdesBot\Games\LeagueOfLegends;

use DateTime;
use LurdesBot\Games\LeagueOfLegends\Entity\Summoner;
use Zttp\Zttp;

class RiotApi {

    /**
     * @param $summonerName
     * @return Summoner
     */
    public static function summonerInfo($summonerName) {
        $getProfile = function ($sm) {
            return Zttp::get('https://br1.api.riotgames.com/lol/summoner/v3/summoners/by-name/' . $sm . '?api_key=' . CONFIG['riot_api_key'])
                ->json();
        };

        $summoner = Summoner::whereNickname($summonerName)->first();
        if (empty($summoner)) {
            $profile = $getProfile($summonerName);

            $summoner = new Summoner();
            $summoner->id = $profile['id'];
            $summoner->nickname = $profile['name'];
            $summoner->account_id = $profile['accountId'];
            $summoner->profile_icon_id = $profile['profileIconId'];
            $summoner->revision_date = $profile['revisionDate'];
            $summoner->saveOrFail();
        } else {
            $now = new DateTime('now');
            $lastUpdatedAt = new DateTime($summoner->updated_at);
            $diff = $now->diff($lastUpdatedAt);

            if ($diff->h >= 1) {
                $profile = $getProfile($summonerName);
                if (!isset($profile['profileIconId']))
                    $summoner->profile_icon_id = $profile['profileIconId'];

                $summoner->revision_date = $profile['revisionDate'];
                $summoner->saveOrFail();
            }
        }

        return $summoner;
    }

    public static function summonerIconUrl($iconId) {
        return 'http://ddragon.leagueoflegends.com/cdn/' . CONFIG['lol_version'] . '/img/profileicon/' . $iconId . '.png';
    }

    public static function championIconUrl($championName) {
        return 'http://ddragon.leagueoflegends.com/cdn/' . CONFIG['lol_version'] . '/img/champion/' . $championName . '.png';
    }

    public static function spellIconUrl($spellImage) {
        return 'http://ddragon.leagueoflegends.com/cdn/' . CONFIG['lol_version'] . '/img/spell/' . $spellImage;
    }

    public static function liveGameData($summonerId) {
        return Zttp::get('https://br1.api.riotgames.com/lol/spectator/v3/active-games/by-summoner/' . $summonerId . '?api_key=' . CONFIG['riot_api_key'])
            ->json();
    }

}