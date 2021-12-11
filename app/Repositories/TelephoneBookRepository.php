<?php

namespace App\Repositories;

use App\Models\TelephoneBook;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class TelephoneBookRepository
{

    /**
     * @var TelephoneBook
     */
    protected $user;

    /**
     * 
     * @param TelephoneBook $telephoneBook;
     */
    public function __construct(TelephoneBook $telephoneBook)
    {
        $this->telephoneBook = $telephoneBook;
    }

    public function getAll(){
        if (Cache::has('telephone')) {
            $data = Cache::get('telephone');
            return $data;
        }
        $data = TelephoneBook::all();
                                
        if(count($data) > 0){
            Cache::put('telephone', $data, 600);
            return $data;
        }else{
            throw new InvalidArgumentException();
        }
    }

    public function search($search){

        $data = TelephoneBook::where('name','LIKE','%'.$search.'%')->get();
        if(count($data) > 0){
            return $data;
        }else {
            throw new InvalidArgumentException('Veri bulunamadi');
        }
        
    }

    public function filter(){

        if (Cache::has('filterasc')) {
            $data = Cache::get('filterasc');
            return response()->json($data, 200);
        }
        $data = TelephoneBook::orderBy('name', 'asc')->get();; 
         
        if(count($data) > 0){
            Cache::put('filterasc', $data, 600);
            return $data;
        }else{
            throw new InvalidArgumentException();
        }

    }

    public function person($data){
        if($data){
            $user = TelephoneBook::create([
                'name' => $data['name'],
            ]);
             return $user;
        }else {
            throw new InvalidArgumentException('İsim boş bırakılmaz');
        }

       /* //second method
        $user = new User();
        // or
        $user = new $this->user();
        $user->name = $data['name'];
        $user->save();
        return $user->fresh();*/

    }

    public function update($data){

        $telephoneBook = TelephoneBook::find($data['id']);
        if($telephoneBook){
            $telephoneBook->name =  $data['name'];
            return $telephoneBook->save();
        }else {
            throw new InvalidArgumentException('Güncelleme başarısız');
        }

    }

    public function delete($id){

        $operation = TelephoneBook::find($id);
        if($operation){
            return $operation->delete();
        }else {
            throw new InvalidArgumentException('Silme işlemi başarısız');
        }

    }

    public function login($user){
        $token = $user->createToken('register_token')->accessToken;
        
        return [
            "data" => $user,
            "token" => $token,
        ];
    }

}

?>