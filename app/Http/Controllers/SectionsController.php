<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $sections = sections::all();

        return view('sections.sections', compact('sections'));
        //return view('sections.sections');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'sections_name' => 'required|string|max:255',
            'description' => 'required'
        ], [
            'sections_name.required' => 'يجب عليك ادخال اسم القسم',
            'description.required' => 'يجب عليك ادخال وصف القسم',
        ]);

        // التحقق من وجود القسم مسبقًا
        $sectionExists = sections::where('sections_name', $request->input('sections_name'))->exists();

        if ($sectionExists) {
            // إذا كان القسم موجودًا، عرض رسالة خطأ
            session()->flash('Error', 'خطأ، القسم مسجل مسبقًا');
            return redirect('/sections');
        } else {
            // إنشاء قسم جديد
            sections::create([
                'sections_name' => $request->input('sections_name'),
                'description' => $request->input('description'),
                'Created_by' => Auth::user()->name,
            ]);

            // عرض رسالة نجاح
            session()->flash('Add', 'تم إضافة القسم بنجاح');
            return redirect('/sections');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sections $sections)
    {
        $id = $request->id;

        $request->validate([
            'sections_name' => 'required|max:255|unique:sections,sections_name,' . $id,
            'description' => 'required'
        ], [
            'sections_name.required' => 'يجب عليك ادخال اسم القسم',
            'sections_name.unique' => 'القسم مسجل مسبقًا',
            'description.required' => 'يجب عليك ادخال وصف القسم',
        ]);

        $sections =  sections::find($id)->update([
            'sections_name' => $request->sections_name,
            'description' => $request->description,
            //'Created_by' => Auth::user()->name,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاح');
        return redirect('/sections');

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');

        //
    }
}
