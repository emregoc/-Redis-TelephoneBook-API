<?php 

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Repositories\TelephoneBookRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TelephoneBookService
{

    /**
     * @var $telephoneBookRepository
     */
    protected $telephoneBookRepository;

    /** UserService Constructor
     * 
     * @param TelephoneBookRepository $telephoneBookRepository;
     */
    public function __construct(TelephoneBookRepository $telephoneBookRepository)
    {
        $this->telephoneBookRepository = $telephoneBookRepository;
    }

    public function getAllTelephoneBook(){
        return $this->telephoneBookRepository->getAll();
    }

    public function searchResult($search){

        if($search){
            $result = $this->telephoneBookRepository->search($search);
            return $result;
        }else{
            throw new InvalidArgumentException('Aranacak kelime giriniz');
        }
    }

    public function filterResult(){
        return $this->telephoneBookRepository->filter();
    }

    public function addPersonData($data){
        $validator = Validator::make($data, [ 
            'name' => 'required|min:2|alpha',
        ]);

        if ($validator->fails()) { // eger hata varsa hata dondurur yoksa diger isleme gecer
            throw new InvalidArgumentException($validator->errors());
        }
        
        $result = $this->telephoneBookRepository->person($data);

        return $result;
    }

    public function personUpdateData($data){
        $validator = Validator::make($data, [ 
            'name' => 'required|min:2|alpha',
        ]);

        if ($validator->fails()) { // eger hata varsa hata dondurur yoksa diger isleme gecer
            throw new InvalidArgumentException($validator->errors());
        }

        $result = $this->telephoneBookRepository->update($data);

        return $result;
    }

    public function personDeleteData($id){

        $result = $this->telephoneBookRepository->delete($id);

        return $result;
    }

    public function userLogin($data){
        $email = $data['email'];
        $password = $data['password'];

        try{
            if(Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();              
                $result = $this->userRepository->login($user);

                return $result;
            }

        }catch(Exception $e){
            $e->getMessage();
        }

       
    }
}

?>