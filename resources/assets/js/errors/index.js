export function handleError (error) {
  // TODO: handle error in user friendly way
  alert(error)
}

export async function execSafe (action = (_) => _, ...args) {
  try {
    return action(args)
  } catch (ex) {
    handleError(ex)
  }
}
