<?php

//fungsi ini untuk tidak mengganggu  query mysql yang di kirim atau melakukan untuk manipulasi.. kalo ga di pake juga gpp sih krna app nya bukan untuk kepentingan khusus
	function antiinjection($data){
		$filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
		return $filter_sql;
	}

?>