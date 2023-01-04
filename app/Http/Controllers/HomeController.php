<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $series = Series::take(4)->get();
        $featuredCourses = Course::take(6)->get();
        return view('welcome', [
            'series' => $series,
            'courses' => $featuredCourses,
        ]);
    }

    public function dashboard()
    {
        if (Auth::user()->type === 1) {
            return view('dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    public function archive($archive_type, $slug)
    {
        $allowed_archive_type = ['series', 'duration', 'level', 'platform', 'topic'];
        if (!in_array($archive_type, $allowed_archive_type)) {
            return abort(404);
        }


        // duraton check
        if ($archive_type === 'duration') {
            $allowed_duration = ['1-5 hours', '5-10 hours', '10+ hours'];
            if (!in_array($slug, $allowed_duration)) {
                return abort(404);
            }
        }

        // series check

        if ($archive_type === 'series') {
            $item = Series::where('slug', $slug)->first();

            if (empty($item)) {
                return abort(404);
            }

            $title ='Courses on '. $item->name;
            $courses = $item->courses()->paginate(12);
        } elseif ($archive_type === 'duration') {

            if ($slug == '1-5 hours') {
                $item = '1-5 hours';
                $duration_db_key = 0;
            } elseif ($slug == '5-10 hours') {
                $item = '5-10 hours';
                $duration_db_key = 1;
            } else {
                $item = '10+ hours';
                $duration_db_key = 2;
            }

            $title = 'Courses with duration '. $item;
            $courses = Course::where('duration', $duration_db_key)->paginate(12);
        }

        // level check
        if ($archive_type === 'level') {
            $allowed_level = ['Beginner', 'Intermediate', 'Advanced'];
            if (!in_array($slug, $allowed_level)) {
                return abort(404);
            }
        }


        return view('archive.single', [
            'title' => $title,
            'courses' => $courses
        ]);
    }
}
