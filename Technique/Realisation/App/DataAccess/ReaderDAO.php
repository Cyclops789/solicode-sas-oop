<?php

namespace App\DataAccess;

use App\DB\Database;
use App\Entities\Reader;

class ReaderDAO
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getReaders(): array
    {
        return $this->database->readers;
    }

    public function addReader(Reader $reader): void
    {
        $this->database->readers = [...$this->database->readers, $reader];
        $this->database->saveData();
    }

    /**
     * @param Reader[] $readers
     * @return void
     */
    public function setReaders($readers): void
    {
        $this->database->readers = $readers;
        $this->database->saveData();
    }

    public function getReader(mixed $needle): Reader|null
    {
        /** @var Reader[] */
        $readers = $this->getReaders();
        $readersFiltered = array_values(array_filter($readers, function (Reader $reader) use ($needle) {
            if ($reader->getId() === (int) $needle) {
                return true;
            }
            return false;
        }));

        if (sizeof($readersFiltered) > 0) {
            return $readersFiltered[0];
        }

        return null;
    }

    /**
     * 
     * @param Reader $reader
     * @return bool true if the reader were found and removed, false if the reader wasnt found
     */
    public function removeReader(Reader $reader): bool
    {
        $readers = $this->getReaders();

        /** @var Reader[] */
        $restOfReaders = array_values(array_filter($readers, function (Reader $readerInstance) use ($reader) {
            if ($readerInstance->getId() === $reader->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfReaders) !== sizeof($readers)) {
            $this->setReaders($restOfReaders);
            return true;
        }

        return false;
    }

    /**
     * @param Reader $reader the edited instance of the book
     * @return bool
     */
    public function editReader(Reader $reader): bool
    {
        $readers = $this->getReaders();

        /** @var Reader[] */
        $restOfReaders = array_values(array_filter($readers, function (Reader $readerInstance) use ($reader) {
            if ($readerInstance->getId() === $reader->getId()) {
                return false;
            }
            return true;
        }));

        if (sizeof($restOfReaders) > 0) {
            $this->setReaders([...$restOfReaders, $reader]);
            return true;
        }

        return false;
    }
}