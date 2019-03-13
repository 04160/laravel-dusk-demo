<?php

namespace App\Http\Controllers;

use App\Models\Value;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function listView(Request $request)
    {
        $value_filter = \Input::get('value');

        $values = Value::orderBy('id');

        if ($value_filter) {
            $values = $values->where('name', 'LIKE', "%$value_filter%");
        }

        $values = $values->get()->toArray();

        return view('list', compact('values'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createValue(Request $request)
    {
        $new_value_name = $request->get('value');
        if (empty($new_value_name)) {
            session()->flash('error', 'Missing value name!');
            return redirect()->back();
        }

        $existing_value = Value::where('name', $new_value_name)->exists();
        if (!empty($existing_value)) {
            session()->flash('error', sprintf('Value with name %s already exists!', $new_value_name));
            return redirect()->back();
        }

        $value = Value::create([
            'name' => $new_value_name
        ]);

        session()->flash('success', sprintf('Value %s created!', $value['name']));
        return redirect()->back();
    }

    public function editValue(Request $request)
    {

    }

    /**
     * @param Request $request
     * @param int     $value_id
     *
     * @return RedirectResponse
     */
    public function deleteValue(Request $request, int $value_id)
    {
        $value = Value::where('id', $value_id)->first();

        if (empty($value)) {
            session()->flash('error', 'Value not found!');
            return redirect()->back();
        }

        $value_name = $value['name'];

        $value->delete();

        session()->flash('success', sprintf('Value %s successfully deleted!', $value_name));
        return redirect()->back();
    }
}
