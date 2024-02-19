<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnotherPackage;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function index($packageId = null)
    {


        if ($packageId != null) {
            $packageData = AnotherPackage::with('book');
            switch ($packageId) {
                case 4:
                    $package = $packageData->where('class', 'الصف الرابع')->get();
                    break;
                case 5:
                    $package = $packageData->where('class', 'الصف الخامس')->get();
                    break;
                case 6:
                    $package = $packageData->where('class', 'الصف السادس')->get();
                    break;
                case 7:
                    $package = $packageData->where('class', 'الصف السابع')->get();
                    break;
                case 8:
                    $package = $packageData->where('class', 'الصف الثامن')->get();
                    break;
                case 9:
                    $package = $packageData->where('class', 'الصف التاسع')->get();
                    break;
                case 10:
                    $package = $packageData->where('class', 'الصف العاشر')->get();
                    break;
                case 11:
                    $package = $packageData->where('class', 'الصف الحادي عشر')->get();
                    break;
                case 12:
                    $package = $packageData->where('class', 'الصف الثاني عشر')->get();
                    break;
                default:
                    // Code to handle when classroom is none of the above
            }

            return response()->json([
                'status' => 200,
                'package' => $package,

            ], 200);
        }
        $bookfour = Book::where('classroom', 'الصف الرابع')->get();
        $bookfive = book::where('classroom', 'الصف الخامس')->get();
        $booksix = Book::where('classroom', 'الصف السادس')->get();
        $bookseven = book::where('classroom', 'الصف السابع')->get();
        $bookeight = book::where('classroom', 'الصف الثامن')->get();
        $booknine = book::where('classroom', 'الصف التاسع')->get();
        $bookten = book::where('classroom', 'الصف العاشر')->get();
        $bookeleven = book::where('classroom', 'الصف الحادي عشر')->get();
        $booktwelve = book::where('classroom', 'الصف الثاني عشر')->get();
        //package

        $packagefour = AnotherPackage::where('class', 'الصف الرابع')->with('book')->get();
        $packagefive = AnotherPackage::where('class', 'الصف الخامس')->with('book')->get();
        $packagesix = AnotherPackage::where('class', 'الصف السادس')->with('book')->get();
        $packageseven = AnotherPackage::where('class', 'الصف السابع')->with('book')->get();
        $packageeight = AnotherPackage::where('class', 'الصف الثامن')->with('book')->get();
        $packagenine = AnotherPackage::where('class', 'الصف التاسع')->with('book')->get();
        $packageten = AnotherPackage::where('class', 'الصف العاشر')->with('book')->get();
        $packageeleven = AnotherPackage::where('class', 'الصف الحادي عشر')->with('book')->get();
        $packagetwelve = AnotherPackage::where('class', 'الصف الثاني عشر')->with('book')->get();
        return response()->json([
            'status' => 200,
            'bookfour' => $bookfour,
            'bookfive' => $bookfive,
            'booksix' => $booksix,
            'bookseven' => $bookseven,
            'bookeight' => $bookeight,
            'booknine' => $booknine,
            'bookten' => $bookten,
            'bookeleven' => $bookeleven,
            'booktwelve' => $booktwelve,
            //
            'packagefour' => $packagefour,
            'packagefive' => $packagefive,
            'packagesix' => $packagesix,
            'packageseven' => $packageseven,
            'packageeight' => $packageeight,
            'packagenine' => $packagenine,
            'packageten' => $packageten,
            'packageeleven' => $packageeleven,
            'packagetwelve' => $packagetwelve,
        ], 200);
    }
    function getBooksAndPackage(Request $request)
    {
        // Define validation rules for book_ids and package_ids as array of integers
        $rules = [
            'book_ids' => 'required|array',
            'book_ids.*' => 'integer|exists:books,id', // Ensure each book ID exists in the books table
            'package_ids' => 'required|array',
            'package_ids.*' => 'integer|exists:another_packages,id', // Ensure each package ID exists in the packages table
        ];

        // Run the validation
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation error response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validation passed, continue with your logic...

        // Access validated data
        $validatedData = $validator->validated();
        $bookIds = $validatedData['book_ids'];
        $packageIds = $validatedData['package_ids'];
        return response()->json([
            'books' => Book::whereIn($bookIds),

            //
            'package' => AnotherPackage::whereIn($packageIds),
        ], 200);
        // Continue with your logic using $bookIds and $packageIds
    }
    public function download($fileName)
    {
        return response()->download(storage_path('app/public/pdf/books/' . $fileName));
    }
}
