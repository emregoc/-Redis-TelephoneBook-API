<?php

namespace App\Http\Controllers;

use App\Events\SendMail;
use App\Models\TelephoneBook;
use App\Services\TelephoneBookService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TelephoneBookController extends Controller
{

    private $telephoneBookService;

    public function __construct(TelephoneBookService $telephoneBookService)
    {
        $this->telephoneBookService = $telephoneBookService;
    }


    /**
     * @OA\Get(
     *      path="/api/data",
     *      operationId="getDataList",
     *      tags={"Data List"},
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      summary="Get list of Datas",
     *      description="Returns list of Datas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function index()
    {

       try{
        $result = $this->telephoneBookService->getAllTelephoneBook();

            return response()->json([
                'status' => 200,
                'success_message' => 'Data list successfuly',
                'data' => $result,
            ], 200);;

        }catch(Exception $e){
            return response()->json([
                'status' => 400,
                'error_message' => $e->getMessage(),
                'error' => 'Not found data',
                'success'=> false,
            ], 400);
        }

    }

    /**
        * @OA\Post(
        * path="/api/person-search",
        * operationId="search",
        * tags={"Search"},
        * security={
        *      {"bearerAuth": {}}
        *   },
        * summary="Person Search",
        * description="Search User Here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="Application/json",
        *               @OA\Schema(
        *               type="object",
        *               required={"search"},
        *               @OA\Property(property="search", type="string"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Search Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Search Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function personSearch(Request $request){ // burada ki veriler cache'den gelemez çünkü,
                                                    // farklı bir arama yaparsa cache'te en son ki veriler
                                                    // olacagi icin ayni sonuclar gelir  
        $search = $request->search;
        try
        {
            $result = $this->telephoneBookService->searchResult($search);
            return response()->json([
                'status' => 200,
                'succes_message' => $search . ' ' .'Arama sonuçları',
                'data' => $result
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'status' => 400,
                'error_message' => $e->getMessage(),
                'error' => 'Arama sonucu bulunmamadi', 
            ], 400);
        }

    }


    /**
     * @OA\Get(
     *      path="/api/person-filter",
     *      operationId="getAscDataList",
     *      tags={"Data List"},
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      summary="Get Asc list of Datas",
     *      description="Returns Asc list of Datas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function personFilter(){

        try{
            $result = $this->telephoneBookService->filterResult();
    
                return response()->json([
                    'status' => 200,
                    'success_message' => 'Data list successfuly',
                    'data' => $result,
                ], 200);;
    
            }catch(Exception $e){
                return response()->json([
                    'status' => 400,
                    'error_message' => $e->getMessage(),
                    'error' => 'Not found data',
                    'success'=> false,
                ], 400);
            }

    }


    /**
        * @OA\Post(
        * path="/api/add-person",
        * operationId="addPerson",
        * tags={"Person Add"},
        * security={
        *      {"bearerAuth": {}}
        *   },
        * summary="Person Add",
        * description="Add User Here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="Application/json",
        *               @OA\Schema(
        *               type="object",
        *               required={"name"},
        *               @OA\Property(property="name", type="string"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Search Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Search Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function addPerson(Request $request){
        
        $data = $request->only([
            'name',
        ]);

        $user = Auth::user();

        try{
            $result = $this->telephoneBookService->addPersonData($data);
                event(new SendMail($user));
                return response()->json([
                    'status' => 200,
                    'success_message' => 'Add Person successfuly',
                    'data' => $result,
                ], 200);;
    
            }catch(Exception $e){
                return response()->json([
                    'status' => 400,
                    'error_message' => $e->getMessage(),
                    'error' => 'Personel Eklenemedi',
                    'success'=> false,
                ], 400);
            }

    }

    /**
     * @OA\PUT(
     *      path="/api/person-update/{id}",
     *      operationId="updatePerson",
     *      tags={"Update Person"},
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      @OA\Parameter(
     *      name="id",
     *      in="path",
     *      @OA\Schema(
     *           type="string"
     *      )
     *      ),
     *      summary="Update Person",
     *      description="Returns Update Person",
     *       @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="Application/json",
    *               @OA\Schema(
    *               type="object",
    *               required={"name"},
    *               @OA\Property(property="name", type="string"),
    *            ),
    *        ),
    *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Update Person",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function personUpdate(Request $request, $id){

        $data = [
            'id' => $id,
            'name' => $request->name,
        ];

        try{
            $result = $this->telephoneBookService->personUpdateData($data);
    
                return response()->json([
                    'status' => 200,
                    'success_message' => 'Update person successfuly',
                    'data' => $result,
                ], 200);;
    
            }catch(Exception $e){
                return response()->json([
                    'status' => 400,
                    'error_message' => $e->getMessage(),
                    'error' => 'Güncelleme işlemi başarısız',
                    'success'=> false,
                ], 400);
            }
       
    }


     /**
     * @OA\DELETE(
     *      path="/api/person-delete/{id}",
     *      operationId="deletePerson",
     *      tags={"Delete Person"},
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      @OA\Parameter(
     *      name="id",
     *      in="path",
     *      @OA\Schema(
     *           type="string"
     *      )
     *      ),
     *      summary="delete Person",
     *      description="Returns delete Person",
     *       
     *      @OA\Response(
     *          response=200,
     *          description="Successful delete Person",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function personDelete($id){

        try{
            $result = $this->telephoneBookService->personDeleteData($id);
    
                return response()->json([
                    'status' => 200,
                    'success_message' => 'Delete person successfuly',
                    'data' => $result,
                ], 200);;
    
            }catch(Exception $e){
                return response()->json([
                    'status' => 400,
                    'error_message' => $e->getMessage(),
                    'error' => 'Veri bulunamadi',
                    'success'=> false,
                ], 400);
            }
    
    }
}
