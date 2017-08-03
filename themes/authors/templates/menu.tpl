
<header>
    <nav id="top-nav">
    	<ul>
        {foreach $menu as $route=>$val}
            <li><a href='index.php?page={$route}' >{$val.title}</a></li>
            {/foreach}     
        </ul>
    </nav>
        
</header>