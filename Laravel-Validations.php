<?php

$rules = [
    'u_first_name' => ['required', 'string', 'max:255'],
    'u_last_name' => ['required', 'string', 'max:255'],
    'u_phone_number' => ['required', 'string', 'max:20'],
    'u_user_role' => ['required', 'integer'],
    'u_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'u_password' => ['required', 'string', 'min:6', 'confirmed'],
];

$customMessages = [
    'u_first_name.required' => 'First name is required field.',
    'u_last_name.required' => 'Last name is required field.',
    'u_phone_number.required' => 'Phone number is required field.',
    'u_user_role.required' => 'Role is required field.',
    'u_email.required' => 'Email is required field.',
    'u_password.required' => 'Password is required field.',
];

return Validator::make($data, $rules, $customMessages);

$validator = \Validator::make($request->all(), $rules, $customMessages);
if ($validator->fails()) {
    $errors = $validator->errors();
    $errors = json_decode($errors);
    return response()->json([
                'success' => false,
                'message' => $errors
                    ], 422);
}


$validator = Validator::make($request->all(), [
            'location_id' => 'required|integer'
        ]);
if ($validator->fails()) {
    $locationserr['result'] = '';
    $locationserr['status'] = 'error';
    $locationserr['code'] = 60;
    return $locationserr;
}
$validator = $this->validator($data);

dd($validator);


if ($validator->fails()) {
    $this->setStatusCode(422);
    return $this->respondWithError($validator->errors());
}


$response = array('response' => '', 'success' => false);
$validator = Validator::make($request->all(), $rules);
if ($validator->fails()) {
    $response['response'] = $validator->messages();
}

return $response;
$this->validate($request->all(), $rules);



$validator = Validator::make($request->all(), $rules, $customMessages);

if ($validator->fails()) {
    $locationserr['result'] = '';
    $locationserr['status'] = false;
    $locationserr['message'] = $validator->errors()->first();
    $locationserr['code'] = 60;
    return $locationserr;
}
