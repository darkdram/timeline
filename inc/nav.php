<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand и toggle сгруппированы для лучшего отображения на мобильных дисплеях -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Brand</a>
        </div>

        <!-- Соберите навигационные ссылки, формы, и другой контент для переключения -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/workers.php">Работники</a></li>
                <li><a href="/groups.php">Бригады</a></li>

                <li><a href="/timeline.php">таймлайн</a></li>
                <li><a href="/timetable.php">таблица</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout.php">Выйти</a></li>
            </ul>
            <p class="navbar-text navbar-right"><?php echo $auth->getUserName(); ?></p>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
