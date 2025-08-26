<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Alpes One Technical Test API",
 * description="API para gerenciar dados do recurso 'listing'.",
 * )
 *
 * @OA\Server(
 * url=L5_SWAGGER_CONST_HOST,
 * description="URL base da API"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * in="header",
 * name="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * )
 */
class ListingController extends Controller
{
    /**
     * @OA\Get(
     * path="/listings",
     * operationId="getListingsList",
     * tags={"Listings"},
     * summary="Listagem paginada de todos os anúncios.",
     * @OA\Parameter(
     * name="page",
     * in="query",
     * description="Número da página",
     * required=false,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(type="object")
     * )
     * )
     */
    public function index()
    {
        return Listing::with('images')->paginate(20);
    }

    /**
     * @OA\Post(
     * path="/listings",
     * operationId="storeListing",
     * tags={"Listings"},
     * summary="Cria um novo anúncio.",
     * @OA\RequestBody(
     * required=true,
     * description="Dados do anúncio a ser criado",
     * @OA\JsonContent(
     * required={"type", "brand", "model", "doors", "board", "transmission", "km", "created", "updated", "sold", "category", "url_car", "price", "color", "fuel"},
     * @OA\Property(property="id", type="integer", nullable=true, example=1),
     * @OA\Property(property="type", type="string", example="Carro"),
     * @OA\Property(property="brand", type="string", example="Honda"),
     * @OA\Property(property="model", type="string", example="Civic"),
     * @OA\Property(property="version", type="string", nullable=true, example="EXL 2.0"),
     * @OA\Property(property="year_model", type="integer", nullable=true, example=2023),
     * @OA\Property(property="year_build", type="integer", nullable=true, example=2022),
     * @OA\Property(property="optionals", type="array", @OA\Items(type="string"), nullable=true, example=null),
     * @OA\Property(property="doors", type="integer", example=4),
     * @OA\Property(property="board", type="string", example="ABC-1234"),
     * @OA\Property(property="chassi", type="string", nullable=true, example="1234567890ABCDEF"),
     * @OA\Property(property="transmission", type="string", example="Automática"),
     * @OA\Property(property="km", type="integer", example=25000),
     * @OA\Property(property="description", type="string", nullable=true, example="Veículo em ótimo estado de conservação."),
     * @OA\Property(property="created", type="string", format="date", example="2023-01-15"),
     * @OA\Property(property="updated", type="string", format="date", example="2023-01-20"),
     * @OA\Property(property="sold", type="boolean", example=false),
     * @OA\Property(property="category", type="string", example="SUV"),
     * @OA\Property(property="url_car", type="string", example="http://example.com/carro-1"),
     * @OA\Property(property="price", type="number", format="float", example=120000.00),
     * @OA\Property(property="old_price", type="number", format="float", nullable=true, example=125000.00),
     * @OA\Property(property="color", type="string", example="Preto"),
     * @OA\Property(property="fuel", type="string", example="Gasolina"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Anúncio criado com sucesso",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="listing", type="object")
     * )
     * )
     * )
     */
    public function store(StoreListingRequest $request)
    {
        $validated = $request->validated();

        $listing = Listing::create($validated);

        return response()->json(['success' => true, 'listing' => $listing], 201);
    }

    /**
     * @OA\Get(
     * path="/listings/{listing}",
     * operationId="getListingById",
     * tags={"Listings"},
     * summary="Retorna um único anúncio.",
     * @OA\Parameter(
     * name="listing",
     * in="path",
     * required=true,
     * description="ID do anúncio",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(type="object")
     * ),
     * @OA\Response(
     * response=404,
     * description="Anúncio não encontrado"
     * )
     * )
     */
    public function show(Listing $listing)
    {
        return $listing->load('images');
    }

    /**
     * @OA\Put(
     * path="/listings/{listing}",
     * operationId="updateListing",
     * tags={"Listings"},
     * summary="Atualiza um anúncio existente.",
     * @OA\Parameter(
     * name="listing",
     * in="path",
     * required=true,
     * description="ID do anúncio",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=false,
     * description="Dados do anúncio a ser atualizado. Note: todos os campos são opcionais.",
     * @OA\JsonContent(
     * @OA\Property(property="type", type="string", example="Carro"),
     * @OA\Property(property="brand", type="string", example="Honda"),
     * @OA\Property(property="model", type="string", example="Civic"),
     * @OA\Property(property="version", type="string", nullable=true, example="EXL 2.0"),
     * @OA\Property(property="year_model", type="integer", nullable=true, example=2023),
     * @OA\Property(property="year_build", type="integer", nullable=true, example=2022),
     * @OA\Property(property="optionals", type="array", @OA\Items(type="string"), nullable=true, example=null),
     * @OA\Property(property="doors", type="integer", example=4),
     * @OA\Property(property="board", type="string", example="ABC-1234"),
     * @OA\Property(property="chassi", type="string", nullable=true, example="1234567890ABCDEF"),
     * @OA\Property(property="transmission", type="string", example="Automática"),
     * @OA\Property(property="km", type="integer", example=25000),
     * @OA\Property(property="description", type="string", nullable=true, example="Veículo em ótimo estado de conservação."),
     * @OA\Property(property="created", type="string", format="date", example="2023-01-15"),
     * @OA\Property(property="updated", type="string", format="date", example="2023-01-20"),
     * @OA\Property(property="sold", type="boolean", example=false),
     * @OA\Property(property="category", type="string", example="SUV"),
     * @OA\Property(property="url_car", type="string", example="http://example.com/carro-1"),
     * @OA\Property(property="price", type="number", format="float", minimum=0, example=120000.00),
     * @OA\Property(property="old_price", type="number", format="float", nullable=true, minimum=0, example=125000.00),
     * @OA\Property(property="color", type="string", example="Preto"),
     * @OA\Property(property="fuel", type="string", example="Gasolina"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Anúncio atualizado com sucesso",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="listing", type="object")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Anúncio não encontrado"
     * )
     * )
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $validated = $request->validated();

        $listing->update($validated);

        return response()->json(['success' => true, 'listing' => $listing]);
    }

    /**
     * @OA\Delete(
     * path="/listings/{listing}",
     * operationId="deleteListing",
     * tags={"Listings"},
     * summary="Remove um anúncio.",
     * @OA\Parameter(
     * name="listing",
     * in="path",
     * required=true,
     * description="ID do anúncio",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=204,
     * description="Anúncio removido com sucesso"
     * ),
     * @OA\Response(
     * response=404,
     * description="Anúncio não encontrado"
     * )
     * )
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return response()->noContent();
    }
}
