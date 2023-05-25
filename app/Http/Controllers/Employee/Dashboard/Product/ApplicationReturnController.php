<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Product\ApplicationReturnRequest;
use App\Models\Client\Market\PurchasedGame;
use App\Models\Employee\Market\ApplicationReturn;
use App\Models\Employee\Market\KeyProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ApplicationReturnController extends Controller
{
    public function __invoke(ApplicationReturnRequest $request)
    {
        try {
            $validation = $request->validated();

            $applicationReturn = new ApplicationReturn();
            $keyProduct = new KeyProduct();
            $purchaase = PurchasedGame::findOrFail($request->purchaseId);
            $existApplication = $applicationReturn->where('purchase_id', $purchaase->id)->where('status', 'Ожидание')->first();

            if ($existApplication) {
                if (array_intersect($existApplication->game_id, $validation['returnKey'])) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Заявка на товар(ы) уже составлена'
                    ]);
                }
            }
            if ($applicationReturn->checkApplicationGame($purchaase->id, $validation['returnKey'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Товар(ы) уже возвращены'
                ]);
            }
            if ($keyProduct->checkCountKeys($validation['returnKey'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Товар(ы) уже возвращены'
                ]);
            }
            $applicationReturn->createApplication($validation['returnKey'], $purchaase->user_id, $purchaase->id, $request->applicationDate);

            return response()->json([
                'success' => true
            ]);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->validator->errors()->all()]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['errors' => $exception->getMessage()]);
        }
    }
}
