const apiDomain = Laravel.apiDomain;
export const companyName = Laravel.companyName;
export const siteName = Laravel.siteName;
export const siteVersion = 'Ver1.0';
export const projectName = Laravel.projectName;

export const login = apiDomain + '/authenticate';
export const currentUser = apiDomain + '/user';
export const currentMenus = apiDomain + '/menus';
export const currentMenuNodes = apiDomain + '/menunodes';
export const currentTabs = apiDomain + '/tabs';
export const currentComponents = apiDomain + '/components';
export const currentProcesses = apiDomain + '/processes';
export const currentUsers = apiDomain + '/users';
export const currentRoles = apiDomain + '/roles';

export const updateRole = apiDomain + '/role/edit/';
export const addRole = apiDomain + '/role/add/';
export const deleteRole = apiDomain + '/role/delete/';

export const updateMenu = apiDomain + '/menu/edit/';
export const addMenu = apiDomain + '/menu/add/';
export const deleteMenu = apiDomain + '/menu/delete/';

export const currentStateNodes = apiDomain + '/statenodes';
export const updateState = apiDomain + '/state/edit/';
export const addState = apiDomain + '/state/add/';
export const deleteState = apiDomain + '/state/delete/';

export const currentUserNodes = apiDomain + '/usernodes';
export const updateUser = apiDomain + '/user/edit/';
export const addUser = apiDomain + '/user/add/';
export const deleteUser = apiDomain + '/user/delete/';