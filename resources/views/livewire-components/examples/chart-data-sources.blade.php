<x-docs-code language="PHP">$rows = collect([
    ['month' => 'Jan', 'amount' => 1200],
    ['month' => 'Feb', 'amount' => 1500],
]);

$data = [
    'labels' => $rows->pluck('month')->all(),
    'datasets' => [['label' => 'Revenue', 'data' => $rows->pluck('amount')->all()]],
];</x-docs-code>