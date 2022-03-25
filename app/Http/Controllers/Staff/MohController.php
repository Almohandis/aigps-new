<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;

class MohController extends Controller {
    //# Get all hospitals to manage each hospital's doctors
    public function manageDoctors(Request $request)
    {
        $hospitals = Hospital::all();
        return view('moh.manage-doctors', compact('hospitals'));
    }

    //# Get all doctors working in a hospital
    public function getDoctors(Request $request, $id)
    {
        $doctors = Hospital::find($id)->clerks()->get();
        $doctors = json_encode($doctors);

        return $doctors;
    }

    //# Remove doctor from a hospital
    public function removeDoctor(Request $request, $id)
    {
        $doctor = User::find($id)->update([
            'hospital_id' => null,
        ]);

        return $doctor;
    }

    //# Add new doctor to a hospital
    public function addDoctor(Request $request)
    {
        if (!$request->hospital_id)
            return redirect('/staff/moh/manage-doctors')->with('message', 'Please select a hospital');
        $hospital = Hospital::find($request->hospital_id);
        if ($hospital)
            $added = User::where('national_id', $request->national_id)->update([
                'hospital_id' => $hospital->id,
            ]);
        else
            $added = false;
        // return $added;
        if ($added)
            return redirect('/staff/moh/manage-doctors')->with('message', 'Doctor added successfully');
        else
            return redirect('/staff/moh/manage-doctors')->with('message', 'Doctor could not be added');
    }

    public function articleForm()
    {
        return view('moh.article-form');
    }

    public function addArticle(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpg,png,jpeg,gif,svg|max:5048',
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        if ($request->image) {
            $imgName  = time() . '.' . $request->image->extension();
            $request->image->move(public_path('article_images'), $imgName);
            $name = $request->file('image')->getClientOriginalName();
        }

        $link = [];
        preg_match('/ src="(.*)" title=/', $request->link, $link);

        Article::create([
            'name'  => $name ?? null,
            'path' => $imgName ?? null,
            'title' => $request->title,
            'content' => $request->content,
            'video_link' => $link[1] ?? null,
            'full_article_link' => $request->full_link ?? null,
        ]);
        return redirect()->back()->with('message', 'Article added successfully');
    }
}
