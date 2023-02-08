<?php

namespace App\Console\Commands;

use App\Http\Resources\DataResource;
use App\Models\Data;
use Illuminate\Console\Command;

class DuplicateDataChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate-data-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected array $datas = [];

    protected $last_duplicate_data_check_id = null;

    public function handle()
    {
        $setting_key = 'last-duplicate-data-check-id';

        // Geçici olarak kapalı. Kararlaştırıldıktan sonra aktif edilecek.
        //$this->last_duplicate_data_check_id = config($setting_key);

        $query = Data::query();
        if (! empty($this->last_duplicate_data_check_id)) {
            $query = Data::where('id', '>', $this->last_duplicate_data_check_id)->get();
        } else {
            $query = Data::all();
        }

        //Data tablosu içerisinde bulunan veriler resource'dan geçirilerek uygun formata dönüştürülüyor.
        collect($query)->each(function ($item) {
            $this->datas[$item->id] = (new DataResource($item))->jsonSerialize();
        });

        $this->line('Total data: '.count($this->datas), 'fg=green');

        //Dataların içerisinde duplicate veriler bulunarak siliniyor.
        collect($this->datas)->duplicatesStrict()->each(function ($item, $key) {
            if (Data::find($key)->delete()) {
                $this->line("ID: $key | Duplicate data deleted...", 'fg=red');
                $this->last_duplicate_data_check_id = $key;
            }
        });

        // Geçici olarak kapalı. Kararlaştırıldıktan sonra aktif edilecek.
        // if(!empty($this->last_duplicate_data_check_id)) {
        //     Setting::updateOrCreate(
        //         [
        //             'meta' => $setting_key,
        //         ],
        //         [
        //             'value' => $this->last_duplicate_data_check_id
        //         ]
        //     );
        // }

        return Command::SUCCESS;
    }
}
