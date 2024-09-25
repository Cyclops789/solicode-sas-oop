<?php

namespace App\Services;

use App\DataAccess\ReaderDAO;
use App\Entities\Reader;

class ReaderService {

    private ReaderDAO $readerDAO;

    public function __construct()
    {
        $this->readerDAO = new ReaderDAO();
    }

    public function getReaders()
    {
        return $this->readerDAO->getReaders();
    }

    public function addReader(Reader $reader)
    {
        $this->readerDAO->addReader($reader);
    }

    public function getReader(mixed $needle): Reader|null
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
                    str_starts_with(strtolower($reader->getFirstName()." ".$reader->getLastName()), strtolower($needle)) || 
                    str_ends_with(strtolower($reader->getFirstName()." ".$reader->getLastName()), strtolower($needle))
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