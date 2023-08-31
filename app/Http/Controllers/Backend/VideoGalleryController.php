<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoGallery;
use Carbon\Carbon; 
use App\Models\LiveTv;
use Intervention\Image\Facades\Image;

class VideoGalleryController extends Controller
{
    public function AllVideoGallery()
    {
        $video = VideoGallery::latest()->get();
        return view('backend.video.all_video',compact('video'));
    }

    public function AddVideoGallery()
    {
        return view('backend.video.add_video');
    } 


    public function StoreVideoGallery(Request $request)
    {
        $image = $request->file('video_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(784,436)->save('upload/video/'.$name_gen);
        $save_url = 'upload/video/'.$name_gen;

        VideoGallery::insert([
            'video_title' => $request->video_title,
            'video_url' => $request->video_url,  
            'post_date' => Carbon::now()->format('d F Y'),
            'video_image' => $save_url, 
        ]);

        $notification = array(
            'message' => 'Video Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.video.gallery')->with($notification);
    }

    public function EditVideoGallery($id)
    {
        $video = VideoGallery::findOrFail($id);
        return view('backend.video.edit_video',compact('video'));
    }


    public function UpdateVideoGallery(Request $request)
    {
        $video_id = $request->id;
        if ($request->file('video_image')) 
        {
            $data = VideoGallery::find($video_id);
            @unlink(public_path($data->video_image));
            $image = $request->file('video_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(784,436)->save('upload/video/'.$name_gen);
            $save_url = 'upload/video/'.$name_gen;

            VideoGallery::findOrFail($video_id)->update([
                'video_title' => $request->video_title,
                'video_url' => $request->video_url,  
                'post_date' => Carbon::now()->format('d F Y'),
                'video_image' => $save_url, 
            ]);

            $notification = array(
                'message' => 'Video Update With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.video.gallery')->with($notification);
        } 
        else
        {
            VideoGallery::findOrFail($video_id)->update([
                'video_title' => $request->video_title,
                'video_url' => $request->video_url,  
                'post_date' => Carbon::now()->format('d F Y'), 
            ]);

            $notification = array(
                'message' => 'Video Update Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.video.gallery')->with($notification);
        }
    }


    public function DeleteVideoGallery($id)
    {
        $photo = VideoGallery::findOrFail($id);
        $img = $photo->video_image;
        unlink($img);

        VideoGallery::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Video Gallery Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    }



    /////////////////// Live TV Method ////////////////
    public function UpdateLiveTv()
    {
        $live = LiveTv::findOrFail(1);
        return view('backend.video.live_tv',compact('live'));
    }
    
    
    public function UpdateLiveData(Request $request)
    {
        $live_id = $request->id;

        if ($request->file('live_image')) 
        {
            $data = LiveTv::find($live_id);
            @unlink(public_path($data->live_image));
            
            $image = $request->file('live_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(784,436)->save('upload/live/'.$name_gen);
            $save_url = 'upload/live/'.$name_gen;

            LiveTv::findOrFail($live_id)->update([
                'live_url' => $request->live_url,   
                'post_date' => Carbon::now()->format('d F Y'),
                'live_image' => $save_url, 
            ]);

            $notification = array(
                'message' => 'Live Tv Update With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } 
        else
        {
            LiveTv::findOrFail($live_id)->update([
                'live_url' => $request->live_url,   
                'post_date' => Carbon::now()->format('d F Y'), 
            ]);

            $notification = array(
                'message' => 'Live Tv Update Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }
}
