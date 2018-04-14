<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Source;

interface SourceInterface
{
    public function getData();

    public function getPaginator();

    public function getSource();
}
