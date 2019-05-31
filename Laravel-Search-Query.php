<?php

$users_list_sql = $users_list_sql->where(\DB::raw("CONCAT(`u_first_name`, ' ', `u_last_name`)"), 'like', '%' . $search . '%');

public function getUserFavoritePeoples($user_id) {
    $data = \App\FavoritePeoples::select(
                    "u_id", "ud_title", "ud_created_at", "u_image", "u_first_name", "u_last_name", "fp_u_id"
            )
            ->join("people_details", "ud_u_id", "=", "fp_p_id")
            ->join("users", "u_id", "=", "ud_u_id")
            ->where("fp_u_id", $user_id);

    if (!empty($request->search_text)) {
        $search_keyword = $request->search_text;
        $data = $data->where(function ($query) use ($search_keyword) {
            $query->orWhere('ud_title', 'like', '%' . $search_keyword . '%')
                    ->orWhere('ud_year_of_experience', 'like', '%' . $search_keyword . '%')
                    ->orWhere('ud_college_name', 'like', '%' . $search_keyword . '%')
                    ->orWhere('ud_salary', 'like', '%' . $search_keyword . '%')
                    ->orWhere('u_first_name', 'like', '%' . $search_keyword . '%')
                    ->orWhere('u_last_name', 'like', '%' . $search_keyword . '%');
        });
    }

    $data = $data->groupBy('ud_u_id')->get();
//        $data = $data->groupBy('ud_u_id')->paginate(10);

    if ($data->isEmpty()) {
        return false;
    }

    foreach ($data as &$value) {
        $value->u_image = $this->getUserImage($value->u_id);
        $value->time_since = time_ago($value->ud_created_at);
        $value->is_liked = !empty($value->fp_u_id) ? true : false;
    }
    return !empty($data) && count($data) > 0 ? $data : array();
}
