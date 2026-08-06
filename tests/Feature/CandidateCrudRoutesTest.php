<?php

test('candidate create view uses the nested election candidate routes', function () {
    $route = route('elections.candidates.store', ['election' => 42]);

    expect($route)->toContain('/elections/42/candidates');
});
