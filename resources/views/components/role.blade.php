@can('admin') {{ '(管理者)' }} @elsecan('checker') {{ '(チェッカー)' }} @endcan