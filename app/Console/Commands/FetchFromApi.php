<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreAndUpdateListingRequest;
use App\Models\Listing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FetchFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esse comando busca informações de registros de venda de veículos em formato JSON e insere no banco, criando um novo registro ou atualizando os já existentes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $data = Http::get(env('API_URL'))->json();

        collect($data)
            ->map(function ($item) {
                unset($item['optionals']);

                $item['year_model'] = $item['year']['model'] ?? null;
                $item['year_build'] = $item['year']['build'] ?? null;
                unset($item['year']);

                return $item;
            })
            ->each(function ($item) {
                try {
                    $request = new StoreAndUpdateListingRequest();

                    $validator = validator($item, $request->rules());

                    if ($validator->fails()) {
                        throw new ValidationException($validator);
                    }

                    $listing = Listing::updateOrCreate(
                        ['id' => $item['id']],
                        $item
                    );

                    if (!isset($item['fotos'])) {
                        return;
                    }

                    // precisa ajustar a lógica de criar / atualizar
                    collect($item['fotos'])->map(
                        function ($image) use ($listing) {
                        $listing->images()->create(['url' => $image]);
                    }
                    );
                } catch (ValidationException $e) {
                    Log::error("Erro de validação para o item com ID {$item['id']}: " . json_encode($e->errors()));
                }
            });
    }
}
