<?php

namespace App\Services;

use App\DataAccess\ReaderDAO;
use App\Entities\Reader;

class ReaderService {

    private ReaderDAO $reader;

    public function __construct()
    {
        $this->reader = new ReaderDAO();
    }

    public function getReaders()
    {
        return $this->reader->getReaders();
    }

    public function addReader(Reader $reader)
    {
        $this->reader->addReader($reader);
    }

    public function getBook(mixed $needle): Reader|null
    {
        /** @var Reader[] */
        $readers = $this->getReaders();

        if(is_numeric($needle)) {
            $readersFiltered = array_filter($readers, function (Reader $reader) use ($needle) {
                if($reader->getId() === (int) $needle) {
                    return true;
                }
                return false;
            });

            if(sizeof($readersFiltered) > 0) {
                return $readersFiltered[0];
            }
        } else {
            $readersFiltered = array_filter($readers, function (Reader $reader) use ($needle) {
                if(
                    str_ends_with(strtolower($reader->getTitle()), strtolower($needle)) || 
                    str_starts_with(strtolower($reader->getTitle()), strtolower($needle))
                ) {
                    return true;
                }
                return false;
            });

            if(sizeof($readersFiltered) > 0) {
                return $readersFiltered[0];
            }
        }

        return null;
    }
}