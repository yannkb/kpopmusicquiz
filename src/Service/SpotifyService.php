<?php
namespace App\Service;

use SpotifyWebAPI\SpotifyWebAPI;
use App\Entity\Song;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManagerInterface;

class SpotifyService
{
    private $spotify;
    private $em;
    private $songRepository;

    public function __construct(SpotifyWebAPI $spotify, EntityManagerInterface $em, SongRepository $songRepository)
    {
        $this->spotify = $spotify;
        $this->em = $em;
        $this->songRepository = $songRepository;
    }

    public function updateSongDatabase(string $playlistId)
    {
        $offset = 0;
        $limit = 100;
        $totalProcessed = 0;

        do {
            try {
                $playlistTracks = $this->spotify->getPlaylistTracks($playlistId, [
                    'offset' => $offset,
                    'limit' => $limit,
                    'fields' => 'items(track(id,name,artists,preview_url)),next'
                ]);
    
                foreach ($playlistTracks->items as $item) {
                    if (isset($item->track)) {
                        $this->processTrack($item->track);
                        $totalProcessed++;
                    }
                }
    
                $this->em->flush();
    
                $totalProcessed += count($playlistTracks->items);
    
                $offset += $limit;
            } catch (\Exception $e) {
                echo "Error processing tracks: " . $e->getMessage() . "\n";
                // Optionally, you might want to break the loop here or continue to the next batch
            }
        } while ($playlistTracks->next);

        echo "Finished processing all tracks.\n";
    }

    private function processTrack($track)
    {
        // Skip tracks without a valid Spotify ID or a valid Preview URL
        if (empty($track->id) || empty($track->preview_url)) {
            echo "Skipping track with no ID or no preview URL: " . json_encode($track) . "\n";
            return;
        }

        $existingSong = $this->songRepository->findOneBy(['spotifyId' => $track->id]);

        if (!$existingSong) {
            $song = new Song();
            $song->setSpotifyId($track->id);
        } else {
            $song = $existingSong;
        }

        $song->setTitle($track->name);
        $song->setArtist($track->artists[0]->name);
        $song->setPreviewUrl($track->preview_url);

        $this->em->persist($song);
    }
}