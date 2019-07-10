<?php
namespace Page;

class DataTableComponent extends AbstractPage
{

    const searchInput = '.dataTables_filter input[type="search"]';
    const firstRowFirstColumn = '.dataTables_wrapper table tbody tr:first-child td:first-child';
    const secondRow = '.dataTables_wrapper table tbody tr:nth-child(2)';

    public function getBaseRequest()
    {
        return [
            'draw' => 1,
            'start' => 0,
            'length' => 999,
            'order' => [
                [
                    'column' => 0,
                    'dir' => 'asc',
                ],
            ],
            'search' => [
                'value' => null,
                'regex' => false,
            ],
        ];
    }

    public function searchFor($text)
    {
        $this->tester->waitForElement(self::searchInput);
        $this->tester->fillField(self::searchInput, $text);
        $this->waitForProcessingComplete();
    }

    public function searchForUnique($text)
    {
        $this->searchFor($text);
        $this->tester->waitForElementNotVisible(self::secondRow);
        $this->waitForProcessingComplete();
    }

    public function clickActionLink($actionType, $actionParams, $withConfirmPreemptYes = true, $waitForProcessing = true)
    {
        $selector = "a[data-action-type=\"{$actionType}\"][data-action-params=\"{$actionParams}\"]";
        if ($withConfirmPreemptYes) {
            $this->tester->alertConfirmPreemptYes();
        }
        $this->tester->click($selector);
        if ($waitForProcessing) {
            $this->waitForProcessingComplete();
        }
    }

    public function clickDelete($id, $actionType = 'delete', $withConfirmPreemptYes = true, $waitForProcessing = true)
    {
        // support multiple ids
        if (is_array($id)) {
            $actionParams = implode('/', $id);
        } else {
            $actionParams = $id;
        }

        $this->clickActionLink($actionType, $actionParams, $waitForProcessing);
    }

    public function seeFirstItemInList($text)
    {
        $this->tester->waitForText("{$text}", $this->tester->defaultWait, self::firstRowFirstColumn);
    }

    public function seeFirstItemInListInColumnNumber($text, $column)
    {
        $this->tester->waitForText("{$text}", $this->tester->defaultWait, ".dataTables_wrapper table tbody tr:first-child td:nth-child($column)");
    }

    public function seeEmptyTable()
    {
        $this->tester->waitForText('No data available in table', $this->tester->defaultWait, self::firstRowFirstColumn);
    }

    public function waitForProcessingComplete()
    {
        $this->tester->waitForElementNotVisible('#data-table_processing');
    }
}
