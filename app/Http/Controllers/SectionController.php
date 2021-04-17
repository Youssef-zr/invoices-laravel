<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'الأقسام';
        $sections = Section::all();

        return view('admin.sections.index', compact('title', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'section_name' => 'required|string|unique:sections,section_name|max:255',
            'note' => 'nullable|string',
        ];

        $niceNames = [
            'section_name' => 'اسم القسم',
            'note' => 'الملاحظات',
        ];

        $data = $this->validate($request, $rules, [], $niceNames);

        $data["added_by"] = auth()->user()->name;

        $new = new Section();
        $new->fill($data)->save();

        $request->session()->flash('msgSuccess', 'تم اضافة القسم بنجاح');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {

        $rules = [
            'section_name' => 'required|string|max:255|unique:sections,section_name,' . $section->id,
            'note' => 'nullable|string',
        ];

        $niceNames = [
            'section_name' => 'اسم القسم',
            'note' => 'الملاحظات',
        ];

        // used this session to show edit section modal
        $request->session()->flash('edit', 'edit');

        $data = $this->validate($request, $rules, [], $niceNames);

        $section->fill($data)->save();

        $request->session()->flash('msgSuccess', 'تم تعديل القسم بنجاح');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        request()->session()->flash('msgSuccess', 'تم حذف القسم بنجاح');

        return redirect()->back();
    }
}
