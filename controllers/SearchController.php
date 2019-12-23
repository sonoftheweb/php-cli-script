<?php

namespace Controllers;

use Controllers\BaseController;
use GuzzleHttp\Client;

class SearchController extends BaseController
{
    /**
     * Runs commands based on the arguments sent
     *
     * @param array $argv
     * @return mixed|void
     */
    public function run(array $argv)
    {
        $search_term = (isset($argv[2])) ? $argv[2] : null;

        if (!$search_term) {
            $this->getApp()->getOutput()->display("Arguments not found.");
            exit;
        }

        $uri = "http://musicbrainz.org/ws/2/artist/?limit=10&query=area:" . $search_term . "&fmt=json";

        $client = new Client([
            'headers' => [
                "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64)",
                "Accept"     => "application/json"
            ]
        ]);

        $response = $client->request("GET", $uri);

        if ($response->getStatusCode() === 200) {
            // get the content and store in CSV file
            $data = \GuzzleHttp\json_decode($response->getBody());

            if (count($data->artists) < 1) {
                $this->getApp()->getOutput()->display("Nothing Found... Please search for something else.");
                exit;
            }

            $artists = [];
            foreach ($data->artists as $artist) {

                $tags = [];
                if (array_key_exists('tags', $artist)) {
                    $tags = array_map(function ($tag) {
                        return $tag->name;
                    }, $artist->tags);
                }

                $artist_name = str_replace('o', '^', strtolower($artist->name));

                $artists[] = [
                    'id' => $artist->id,
                    'name' => ucwords($artist_name),
                    'tags' => implode(', ', $tags)
                ];
            }

            $file = $this->generateCsvFile($artists);
            $this->getApp()->getOutput()->display("File successfully generated at " . $file);
        } else {
            $this->getApp()->getOutput()->display("Something went wrong, Please try again.");
        }
    }

    /**
     * Build, store and output csv file (location string) when data is provided
     *
     * @param array $data
     * @return mixed|string
     */
    function generateCsvFile(array $data) {
        $csv_filename = "artists_".date("Y-m-d_H-i",time()).".csv";
        $file = fopen(__DIR__ . '/../files/'.$csv_filename, 'wb');

        $headers = array_keys($data[0]);
        fputcsv($file, $headers);

        foreach ($data as $artist) {
            $row = array_values($artist);
            fputcsv($file, $row);
        }

        return '/files/' . $csv_filename;
    }
}