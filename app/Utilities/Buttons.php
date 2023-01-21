<?php

namespace App\Utilities;

class Buttons 
{
    //1.view button 2.edit button 3.delete button
    public static function dataTableButtons($viewRoute, $editRoute, $deleteRoute)
    {
        return '<div class="margin">
                    <div class="btn-group">
                        <a href="'.$viewRoute.'" class="btn btn-xs btn-info"><i class="fa fa-bars"></i> Show</a>
                    </div>
                    <div class="btn-group">
                        <a href="'.$editRoute.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                    <div class="btn-group">
                        <form action="'.$deleteRoute.'" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">  
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                            Delete
                            </button>
                        </form>
                    </div>
               </div>';
    }

    public static function resetButton($route)
    {
        return '
            <div class="btn-group">
            <form action="'.$route.'" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="'.csrf_token().'">  
                <button type="submit" class="btn btn-xs btn-secondary"><i
                class="fa fa-plus-circle"></i> Reset
                </button>
            </form>
            </div>
        ';
    }

    public static function activateDeactivateButton($status, $activateRoute, $deactivateRoute)
    {
        $buttons = new Buttons;
        if ($status == 0) {
            return $buttons->activateButton($activateRoute);
        }
        return $buttons->deactivateButton($deactivateRoute);
    }

    public static function activateButton($route)
    {
        return '
            <div class="btn-group">
            <form action="'.$route.'" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="'.csrf_token().'">  
                <button type="submit" class="btn btn-xs btn-danger"><i
                class="fa fa-times-circle"></i>
                </button>
            </form>
            </div>
        ';
    }

    public function deactivateButton($route)
    {
        return '
            <div class="btn-group">
                <form action="'.$route.'" method="post">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="'.csrf_token().'">  
                <button type="submit" class="btn btn-xs btn-success"><i
                class="fa fa-check-circle"></i>
                </button>
                </form>
            </div>
            ';
    }

    public static function dataTableViewButton($viewRoute)
    {
        return '<div class="margin">
                    <div class="btn-group">
                        <a href="'.$viewRoute.'" class="btn btn-xs btn-info"><i class="fa fa-bars"></i> Show</a>
                    </div>
               </div>';
    }

    public static function dataTableClientNameLink($id, $name)
    {
        return '<a href="/records/clients/'.$id.'">'.$name.'</a>';
    }

    public static function dataTableEditButton($viewRoute, $editRoute, $deleteRoute)
    {
        return '
            <div class="margin">
                <div class="btn-group">
                    <a href="'.$editRoute.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                </div>
            </div>
           ';
    }

    public static function dataTableShowButton($route)
    {
        return '
            <div class="margin">
                <div class="btn-group">
                    <a href="'.$route.'" class="btn btn-xs btn-info"><i class="fa fa-bars"></i> Show</a>
                </div>
            </div>
           ';
    }

    public static function dataTableDeleteButton($route)
    {
        return '
            <div class="margin">
                <div class="btn-group">
                    <form action="'.$route.'" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'">  
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                          Delete
                        </button>
                    </form>
                </div>
            </div>
           ';
    }

   
}
?>