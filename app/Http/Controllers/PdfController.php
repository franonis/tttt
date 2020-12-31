<?php

namespace App\Http\Controllers;

use Response;

class PdfController extends Controller
{
    public function getpdf($name)
    {
        #$document = Document::findOrFail($id);

        $filePath = 'images/MARresults/PCA_score_plot_all.pdf';
        #$filePath = storage_path('storage/uploads/PCA_score_plot_all.pdf');

        return response()->file($filePath);
    }
}
