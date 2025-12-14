<?php

// NOTE:
// Feature tests in this project use in-memory SQLite via RefreshDatabase (see `tests/Pest.php`).
// If the local PHP runtime is missing the `pdo_sqlite` extension, any Feature test will fail
// before assertions. Vehicle creation is therefore covered in a Unit test that doesn't require DB.
