<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class VideoCest
{
    protected $formId = '#w0';

    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function createVideoWithoutData(FunctionalTester $I)
    {
        $I->amOnPage('/video/create');
        $I->see('Create video', 'h1');
        $I->see('Drag and drop a file you want to upload');
        $I->submitForm($this->formId, []);
        $I->see('Video ID cannot be blank.');
    }
}
