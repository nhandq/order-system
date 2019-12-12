<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //block some ip here
        if (\Request::ip() == '127.0.1.1') {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $processType = ['normal', 'urgent', 'supper urgent'];
        $purpose = ['tourist visa', 'business visa', 'other'];
        return [
            'user_id' => 'required|integer',
            'number_of_visa' => ['required', 'regex:/^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/i'],
            'visa_type' => 'required',
            'airport_arrival' => 'required',
            'process_type' => 'required|in:'. implode(',', $processType),
            'purpose' => 'required|in:' . implode(',', $purpose),
            'date_of_arrival' => 'required|date|after:today',
            'date_of_departure' => 'required|date|after_or_equal:date_of_arrival',
            'payment_type' => 'required',
            'passport_full_name' => 'required|array',
            'passport_gender' => 'required|array',
            'passport_date_of_birth' => 'required|array',
            'nationality' => 'required|array',
            'passport_number' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User id is required!',
            'number_of_visa.required' => 'Visa is required!',
            'visa_type.required' => 'Visa is required!',
            'airport_arrival.required' => 'Airport of arrival is required!',
            'process_type.required' => 'Processing type is required!',
            'purpose.required' => 'Purpose is required!',
            'date_of_arrival.required' => 'Date of Arrival is required!',
            'date_of_departure.required' => 'Date of Departure is required!',
            'payment_type.required' => 'Payment type is required!',
            'passport_full_name.required' => 'Full name of passport is required!',
            'passport_gender.required' => 'Passport gender is required!',
            'passport_date_of_birth.required' => 'Passport date of birth is required!',
            'nationality.required' => 'Nationality is required!',
            'passport_number.required' => 'Passport number is required!',

            'number_of_visa.regex' => 'Wrong number of visa',
            'process_type.in' => 'Processing type must be one of (\'normal\', \'urgent\', \'supper urgent\')',
            'purpose.in' => 'Purpose must be one of (\'tourist visa\', \'business visa\', \'other\')',
            'date_of_arrival.after' => 'Arrival Date must greater than Current Date!',
            'date_of_departure.after' => 'Departure Date must equal or greater than Arrival Date!',
            'date_of_arrival.data' => 'Arrival Date must be type of date',
            'date_of_departure.date' => 'Departure Date be type of date',
            'passport_full_name.array' => 'Full name of passport must be type of array',
            'passport_gender.array' => 'Passport gender must be type of array',
            'passport_date_of_birth.array' => 'Passport date of birth must be type of array',
            'nationality.array' => 'Nationality must be type of array',
            'passport_number.array' => 'Passport number must be type of array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => 422,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
