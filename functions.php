<?php
use Pagination\Pagination;
use Pagination\StrategySimple;

include 'config.php';

function db()
{
    static $db = null;
    include 'config.php';

    if ($db === null) {
        try {
            $db = new PDO(
                'mysql:host=' . $dbConfig['db_host'] . ';dbname=' . $dbConfig['db_name'] . ';charset=utf8',
                $dbConfig['db_user'],
                $dbConfig['db_pass']
            );
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die('Database error: ' . $e->getMessage());
        }
    }

    return $db;
}

function render($template, $data = [])
{
    include 'view/' . $template . '.php';
}

function getCurDir()
{
    $requestUri = $_SERVER['REQUEST_URI'];
    $arRequestUri = parse_url($requestUri);

    return $arRequestUri['path'];
}

function addHeaderStyles()
{
    $arRes = array_diff(scandir('res/css'), ['.', '..']);

    $headerString = '';
    foreach ($arRes as $res) {
        $headerString .= '<link rel="stylesheet" href="/res/css/' . $res . '">';
    }

    echo $headerString;
}

function getPagination($count, $page, $elemPerPage = 3)
{
    $paginationHTML = '';
    $pagination = new Pagination($count, $elemPerPage, $page);
    $indexes = $pagination->getIndexes(new StrategySimple(15));
    $iterator = $indexes->getIterator();

    if ($pagination->getPreviousPage() === 1) {
        $previousPageLink = '/';
    } else {
        $previousPageLink = '?page=' . $pagination->getPreviousPage();
    }

    $paginationHTML .=  '<nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center"">
                                <li class="page-item">
                                    <a class="page-link" href="/" aria-label="First">
                                        <span aria-hidden="true">Начало</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="' . $previousPageLink . '" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>';

    while ($iterator->valid()) {
        $page = $iterator->current();
        if ($page === 1) {
            $paginationHTML .= '<li class="page-item">
                                    <a class="page-link" href="/">1</a>
                                </li>';
        } else {
            $paginationHTML .= '<li class="page-item">
                                    <a class="page-link" href="?page=' . $page . '">
                                        ' . $page . '
                                    </a>
                                </li>';
        }

        $iterator->next();
    }

    $paginationHTML .= '<li class="page-item">
                            <a class="page-link" href="?page=' . $pagination->getNextPage() . '" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=' . $pagination->getLastPage() . '" aria-label="Last">
                                <span aria-hidden="true">Конец</span>
                            </a>
                        </li>
                    </ul>
                </nav>';

    return $paginationHTML;
}