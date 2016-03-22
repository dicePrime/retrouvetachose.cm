<?php

namespace lostBook\lostBookUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class lostBookUserBundle extends Bundle
{
   public function getParent()
    {
        return 'FOSUserBundle';
    }
}
