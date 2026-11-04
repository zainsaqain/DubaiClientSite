<nav class="customer-account-nav" aria-label="Customer account navigation">
    <a href="{{ route('account.dashboard') }}" @class(['is-active' => request()->routeIs('account.dashboard')])>My Account</a>
    <a href="{{ route('account.profile') }}" @class(['is-active' => request()->routeIs('account.profile*')])>Profile</a>
    <a href="{{ route('account.orders') }}" @class(['is-active' => request()->routeIs('account.orders')])>Order History</a>
    <a href="{{ route('account.wishlist') }}" @class(['is-active' => request()->routeIs('account.wishlist')])>Wishlist</a>
</nav>
