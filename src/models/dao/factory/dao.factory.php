<?php

interface IDaoFactory {
    function createUserDao();
    function createMessageDao();
    function createLikeDao();
    function createFollowingDao();
}