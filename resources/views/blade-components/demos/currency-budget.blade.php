<x-sirius::currency id="blade-currency-budget" label="Project budget" name="budget"
    :value="session('sample-currency.budget', '')" error-bag="currency" prefix="$" min="0" required
    helper="Set the budget for the website redesign in USD." />
