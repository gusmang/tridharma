<?php

namespace App\Traits;

trait StripTag{

    public function stripTagFilter(){
        return '<iframe><br><p><ul><ol><li><b><i><strong><em>';
    }
}
