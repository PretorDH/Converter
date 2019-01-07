<?php
/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2018
 * Time: 14:42
 */

use app\common\View;
use app\controllers\guest\Currency;

?>
<div class="row justify-content-center">
	<div class="col-md-6 card card-body mb-3">
		<form action="/convert" method="post" enctype="multipart/form-data">
			<div class="form-row align-item-start">
				<div class="input-group mb-2 col-6">
					<div class="input-group-append">
						<div class="input-group-text"><?= Currency::USD_SYMBOL ?></div>
					</div>
					<input name="usdVolume" type="text" class="form-control"
						   placeholder="USD volume" value="100" required>
					<div class="invalid-feedback">
						Enter usd count.
					</div>
				</div>
				<div class="input-group mb-2 col-6">
					<input name="toSymbol" type="text" class="form-control" list="symbols"
						   placeholder="convert to" value="RUB" required>
					<datalist id="symbols">
                        <?php foreach ($symbols as $symbol): ?>
                            <?= new View('components/converter-symbol.php', ['symbol' => $symbol]) ?>
                        <?php endforeach; ?>
					</datalist>
					<div class="input-group-append">
						<var class="input-group-text" id="convertedValue">0</var>
					</div>
					<div class="invalid-feedback">
						Choice conversion symbol
					</div>
				</div>
			</div>
			<div class="form-group text-right mb-0">
				<span id="convertedText" class="float-left"></span>
				<button type="submit" class="btn btn-primary">Convert</button>
			</div>
		</form>
	</div>
</div>
