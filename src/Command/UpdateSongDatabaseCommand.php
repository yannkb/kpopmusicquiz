<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\SpotifyService;

#[AsCommand(
    name: 'app:update-song-database',
    description: 'Updates the song database from Spotify playlist',
)]
class UpdateSongDatabaseCommand extends Command
{
    private $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $playlistId = '76D3ju1S3uddfAQtwPTuqb';
        $this->spotifyService->updateSongDatabase($playlistId);
        $output->writeln('Song database updated successfully.');

        return Command::SUCCESS;
    }
}